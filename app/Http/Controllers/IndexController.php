<?php

namespace App\Http\Controllers;

use App\Enum\Rule;
use App\Models\Category;
use App\Models\HackHardwareResult;
use App\Models\HackSensorResult;
use App\Models\Machine;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function setting(Request $request)
    {
        return view('setting');
    }

    public function index(Request $request)
    {
        $machineName = $request->input('machineName');
        $category = $request->input('category');
        $errorType = $request->input('errorType');
        $searchDate = $request->input('searchDate');

        $categories = Cache::remember('category-map', 3600, function () {
            return Category::query()
                ->where('depth', 'second')
                ->where('is_hide', 0)
                ->whereNull('machine_type')
                ->select(['id', 'category_name'])
                ->get();
        });
        $records = HackHardwareResult::query()
            ->with(['machine', 'category', 'device.product', 'sensor.product'])
            ->when(!empty($machineName), function (Builder $query) use ($machineName) {
                $machineIds = Machine::query()
                    ->where('machine_name', 'like', "$machineName%")
                    ->select(['id']);
                $query->whereIn('machine_id', $machineIds);
            })
            ->when(!empty($category), function (Builder $query) use ($category) {
                $query->where('category_id', $category);
            })
            ->when(!empty($errorType), function (Builder $query) use ($errorType) {
                $query->where('rule_id', $errorType);
            })
            ->when(!empty($searchDate), function (Builder $query) use ($searchDate) {
                $query->where('day', $searchDate);
            })
            ->orderBy('id')
            ->paginate();

        return view('index', [
            'records' => $records,
            'categories' => $categories,
            'ruleMap' => Rule::MAP
        ]);
    }

    public function show($id)
    {
        $record = HackHardwareResult::query()->where('id', $id)
            ->with(['machine', 'category', 'device.product', 'sensor.product'])
            ->first();

        $longitude = $record?->longitude;
        $latitude = $record?->latitude;
        // 异常数据类型分布
        $errorMap = HackSensorResult::query()->select('rule_id', DB::raw('count(*) as value'))
            ->where('machine_id', $record?->machine_id)
            ->where('day', now()->toDateString())
            ->groupBy('rule_id')
            ->get();
        $ruleIds = $errorMap->pluck('rule_id')->toArray();
        $pieCounts = $errorMap->transform(function ($item) {
            return ['name' => Rule::translate($item->rule_id), 'value' => $item->value];
        })->values()->toArray();
        $ruleNames = collect($pieCounts)->pluck('name')->toArray();

        // 异常数据趋势
        $today = Carbon::now();
        $startDate = $today->copy()->subDays(6);
        $period = CarbonPeriod::create($startDate, $today);

        $ruleId = \request()->get('rule_id', $ruleIds[0] ?? 1);

        $xDate = [];
        $y1 = [];
        $y2 = [];
        $y3 = [];
        /** @var Carbon $date */
        foreach ($period as $date) {
            $xDate[] = $date->format('m-d');
            // 每日异常次数
            $y1[] = HackSensorResult::query()->where('machine_id', $record?->machine_id)
                ->where('day', $date->toDateString())
                ->count();
            // 同型号终端平均值
            $machineIds = HackSensorResult::query()->where('day', $date->toDateString())
                ->whereHas('sensor.product', function (Builder $query) use ($record) {
                    $query->where('id', $record->sensor?->product?->id);
                })->pluck('machine_id')->unique()->toArray();
            if (!$machineIds) {
                $machineIds = [null];
            }

            $averageCount = DB::select("SELECT AVG(cnt) AS average_count
FROM (
    SELECT machine_id, COUNT(*) AS cnt
    FROM `hack_sensor_result`
    WHERE machine_id IN (?)
    AND day = ?
    AND rule_id = ?
    GROUP BY machine_id
) AS subquery;", [implode(',', $machineIds), $date->toDateString(), $ruleId]);

            $y2[] = (int)$averageCount[0]->average_count;
            // 同区域终端平均值
            $areaMachineIds = DB::table('hack_sensor_result')
                ->select('machine_id')
                ->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", [$latitude, $longitude, $latitude])
                ->having('distance', '<', 10)
                ->get()->pluck('machine_id')->unique()->values()->toArray();
            if (!$areaMachineIds) {
                $areaMachineIds = [null];
            }

            $averageCount2 = DB::select("SELECT AVG(cnt) AS average_count
FROM (
    SELECT machine_id, COUNT(*) AS cnt
    FROM `hack_sensor_result`
    WHERE machine_id IN (?)
    AND day = ?
    AND rule_id = ?
    GROUP BY machine_id
) AS subquery;", [implode(',', $areaMachineIds), $date->toDateString(), $ruleId]);
            $y3[] = (int)$averageCount2[0]->average_count;
        }

        $dataStatistics = [];
        foreach (Rule::MAP as $id => $name) {

            $dataStatistics[] = [
                'name' => $name,
                'today' => HackSensorResult::query()->where('machine_id', $record?->machine_id)
                    ->where('day', $today->copy()->toDateString())
                    ->where('rule_id', $id)
                    ->count(),
                'three_day' => HackSensorResult::query()->where('machine_id', $record?->machine_id)
                    ->whereBetween('day', [$today->copy()->subDays(2)->toDateString(), $today->copy()->toDateString()])
                    ->where('rule_id', $id)
                    ->count(),
            ];
        }

        return view('detail', [
            'record' => $record,
            'rule_ids' => $ruleIds,
            'pieCounts' => $pieCounts,
            'ruleIds' => $ruleIds,
            'ruleNames' => implode(',', $ruleNames),
            'xDate' => $xDate,
            'y1' => $y1,
            'y2' => $y2,
            'y3' => $y3,
            'dataStatistics' => $dataStatistics,
        ]);
    }
}
