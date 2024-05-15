<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Services\CheckService;
use Illuminate\Support\Facades\Auth;
use App\Repositories\RecurringRepository;

class CheckController extends Controller
{
    function __construct(
        protected CheckService $checkService,
        protected RecurringRepository $recurringRepository
    ) {
    }
    public function index()
    {
        $userId = Auth::user()->id;
        $todos = $this->checkService->show($userId);
        // dd($todos);
        return view('todos.checks', compact('todos'));
    }

    public function chart()
    {
        $userId = Auth::user()->id;
        $todos = $this->checkService->chart($userId);
        // dd($todos);
        return view('todos.charts', compact('todos'));
    }
    
    public function getChartData(Request $request, $recurringInstanceId)
    {
        $requestData = json_encode($request->json('instancesData'));
        $instancesData = json_decode($requestData);
        $currentIndex = $instancesData->currentIndex;  
        $recurringInstance = $instancesData->instances[$currentIndex];

        $chartData = [
            'labels' => [$this->recurringRepository->createDateRange($recurringInstance)], // 示例
            'datasetsData' => [$this->recurringRepository->getDailyChecks($recurringInstance)],
            'max' => $recurringInstance->goal_value,
        ];
        
        return response()->json($chartData);
    }

    // private function prepareChartData($recurringInstance)
    // {
    //     // 准备数据逻辑
    //     return [
    //         'labels' => , // 示例
    //         'datasets' => [
    //             [
    //                 'label' => 'Data',
    //                 'data' => [10, 20, 30] // 示例
    //             ]
    //         ]
    //     ];
    // }

    // 在 TodoController 中
    public function record(Request $request, $recurringInstanceId)
    {
        $value = (int) $request->value;
        $isCompleted = $request->isCompleted;

        $this->checkService->update($value, $isCompleted, $recurringInstanceId);

        $this->checkService->create($value, $recurringInstanceId);

        return response()->json(['message' => 'Todo record successfully!']);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
