<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tasks = Task::withCount('employees')->with('employees:id')->get();
            return $this->sendResponse($tasks, 'Task Data fetch successfully.',200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendError([], 'Something went wrong',500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,onhold,complete',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'employee_ids' => 'array'
        ]);

        DB::beginTransaction();

        try {
            $task = Task::create([
                'name' => $requestData['name'],
                'description' => $requestData['description'],
                'status' => $requestData['status'],
                'start_date' => $requestData['start_date'],
                'end_date' => $requestData['end_date']
            ]);

            if (isset($requestData['employee_ids'])) {
                $hoursData = [];
                foreach ($requestData['employee_ids'] as $employeeId) {
                    $hoursData[$employeeId] = ['hours' => 0];
                }
            
               $task->employees()->sync($hoursData);
            }

            DB::commit();
            $task->employees_count = $task->employees->count();
         
            return $this->sendResponse($task, 'Record created Successfully', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());
            return $this->sendError([], 'Something went wrong', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $requestData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,onhold,complete',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'employee_ids' => 'array'
        ]);

        DB::beginTransaction();

        try {
            $task = Task::findOrFail($id);
            $task->update([
                'name' => $requestData['name'],
                'description' => $requestData['description'],
                'status' => $requestData['status'],
                'start_date' => $requestData['start_date'],
                'end_date' => $requestData['end_date']
            ]);

            if (isset($requestData['employee_ids'])) {
                $hoursData = [];
                foreach ($requestData['employee_ids'] as $employeeId) {
                    $hoursData[$employeeId] = ['hours' => 0];
                }
            
               $task->employees()->sync($hoursData);
            }

            DB::commit();
            $task->employees_count = $task->employees->count();
         
            return $this->sendResponse($task, 'Record updated Successfully', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());
            return $this->sendError([], 'Something went wrong', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $project = Task::findOrFail($id);
            $project->delete();

            return $this->sendResponse($project, 'Record Deleted Successfully', 200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendError([], 'Something went wrong', 500);
        }
    }
}
