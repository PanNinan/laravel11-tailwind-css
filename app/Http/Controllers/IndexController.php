<?php

namespace App\Http\Controllers;

use App\Enum\Rule;
use App\Models\Category;
use App\Models\HackHardwareResult;
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
        $searchDate = $request->input('searchDate', now()->toDateString());

        $categories = Cache::remember('category-map', 3600, function () {
            return Category::query()
                ->where('depth', 'second')
                ->where('is_hide', 0)
                ->whereNull('machine_type')
                ->select(['id', 'category_name'])
                ->get();
        });
        $today = now();
        $records = HackHardwareResult::query()
            ->with(['machine', 'category', 'device.product', 'sensor.product'])
//            ->where('hour', $today->copy()->subHour()->format('G'))
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
            ->when(empty($searchDate), function (Builder $query) {
                $query->where('day', '>=', now()->toDateString());
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
        $errorMap = HackHardwareResult::query()->select('rule_id', DB::raw('count(*) as value'))
            ->where('machine_id', $record?->machine_id)
            ->where('day', $record?->day)
//            ->where('hour', $record?->hour)
            ->groupBy('rule_id')
            ->get();
        $ruleIds = $errorMap->pluck('rule_id')->toArray();
        $ruleIdMap = collect(Rule::MAP)->only($ruleIds)->all();
        $pieCounts = $errorMap->transform(function ($item) {
            return ['name' => Rule::translate($item->rule_id), 'value' => $item->value];
        })->values()->toArray();
        $ruleNames = collect($pieCounts)->pluck('name')->toArray();

        // 异常数据趋势
        $today = Carbon::now();
        $recordDay = explode('-', $record?->day);
        $recordHour = $record?->hour;
        $date = Carbon::create($recordDay[0] ?? 2024, $recordDay[1] ?? 5, $recordDay[2] ?? 25, $recordHour);
        $startDate = $date->copy()->subHours(6);
        $period = CarbonPeriod::create($startDate, $date);

        $ruleId = \request()->input('rule_id', $ruleIds[0] ?? 1);

        $xDate = [];
        $y1 = [];
        $y2 = [];
        $y3 = [];
        /** @var Carbon $date */
        foreach ($period->hours() as $date) {
            $xDate[] = $date->format('H:i');
            // 每日异常次数
            $y1[] = HackHardwareResult::query()->where('machine_id', $record?->machine_id)
                ->where('day', $date->toDateString())
                ->where('hour', $date->format('G'))
                ->when($ruleId, function (Builder $query) use ($ruleId) {
                    $query->where('rule_id', $ruleId);
                })
                ->count();
            // 同型号终端平均值
            $machineIds = HackHardwareResult::query()
                ->where('day', $date->toDateString())
                ->where('hour', $date->format('G'))
                ->when($ruleId, function (Builder $query) use ($ruleId) {
                    $query->where('rule_id', $ruleId);
                })
                ->whereHas('sensor.product', function (Builder $query) use ($record) {
                    $query->where('id', $record?->sensor?->product?->id);
                })->pluck('machine_id')->unique()->toArray();
            if (!$machineIds) {
                $machineIds = [null];
            }
            $averageCount = DB::select("SELECT AVG(cnt) AS average_count
FROM (
    SELECT machine_id, COUNT(*) AS cnt
    FROM `hack_hardware_result`
    WHERE machine_id IN (?)
    AND day = ?
    AND hour = ?
    AND rule_id = ?
    GROUP BY machine_id
) AS subquery;", [implode(',', $machineIds), $date->toDateString(), $date->format('G'), $ruleId]);

            $y2[] = (int)$averageCount[0]->average_count;
            // 同区域终端平均值
            $areaMachineIds = DB::table('hack_hardware_result')
                ->select('machine_id')
                ->where('day', $date->toDateString())
                ->where('hour', $date->format('G'))
                ->when($ruleId, function (\Illuminate\Database\Query\Builder $query) use ($ruleId) {
                    $query->where('rule_id', $ruleId);
                })
                ->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", [$latitude, $longitude, $latitude])
                ->having('distance', '<', 10)
                ->get()
                ->pluck('machine_id')->unique()->values()->toArray();
            if (!$areaMachineIds) {
                $areaMachineIds = [null];
            }

            $averageCount2 = DB::select("SELECT AVG(cnt) AS average_count
FROM (
    SELECT machine_id, COUNT(*) AS cnt
    FROM `hack_hardware_result`
    WHERE machine_id IN (?)
    AND day = ?
    AND hour = ?
    AND rule_id = ?
    GROUP BY machine_id
) AS subquery;", [implode(',', $areaMachineIds), $date->toDateString(), $date->format('G'), $ruleId]);
            $y3[] = (int)$averageCount2[0]->average_count;
        }
        $dataStatistics = [];
        foreach (Rule::MAP as $id => $name) {
            $dataStatistics[] = [
                'rule_id' => $id,
                'name' => $name,
                'today' => HackHardwareResult::query()->where('machine_id', $record?->machine_id)
                    ->where('day', $today->copy()->toDateString())
                    ->where('rule_id', $id)
                    ->select(['id', 'day', 'hour'])
                    ->get(),
                'three_day' => HackHardwareResult::query()->where('machine_id', $record?->machine_id)
                    ->whereBetween('day', [$today->copy()->subDays(2)->toDateString(), $today->copy()->toDateString()])
                    ->where('rule_id', $id)
                    ->select(['id', 'day', 'hour'])
                    ->get(),
            ];
        }

        //智能分析话术
        $reasons = collect(Rule::REASON)->only($ruleIds)->all();

        return view('detail', [
            'record' => $record,
            'rule_ids' => $ruleIds,
            'ruleIdMap' => $ruleIdMap,
            'reasons' => $reasons,
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
