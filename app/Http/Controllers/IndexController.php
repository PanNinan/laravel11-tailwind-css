<?php

namespace App\Http\Controllers;

use App\Enum\Rule;
use App\Models\Category;
use App\Models\HackTerminalResult;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function setting(Request $request)
    {
        return view('setting');
    }

    public function index(Request $request)
    {
        $categories = Category::query()
            ->where('depth', 'second')
            ->where('is_hide', 0)
            ->whereNull('machine_type')
            ->select(['id', 'category_name'])
            ->get();
        $records = HackTerminalResult::query()->with(['machine', 'category', 'device'])->paginate();
        
        return view('index', ['records' => $records, 'categories' => $categories, 'ruleMap' => Rule::MAP]);
    }

    public function show($id)
    {
        return view('detail', ['id' => $id]);
    }
}
