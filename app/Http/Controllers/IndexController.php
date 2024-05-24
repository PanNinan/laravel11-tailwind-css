<?php

namespace App\Http\Controllers;

use App\Enum\Rule;
use App\Models\Category;
use App\Models\HackTerminalResult;
use App\Models\Machine;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

        $categories = Cache::remember('category-map', 3600, function () {
            return Category::query()
                ->where('depth', 'second')
                ->where('is_hide', 0)
                ->whereNull('machine_type')
                ->select(['id', 'category_name'])
                ->get();
        });
        $records = HackTerminalResult::query()
            ->with(['machine', 'category', 'device'])
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
            ->paginate();

        return view('index', ['records' => $records, 'categories' => $categories, 'ruleMap' => Rule::MAP]);
    }

    public function show($id)
    {
        return view('detail', ['id' => $id]);
    }
}
