<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $projects = Project::withCount('employees')->with('employees:id')->get();
            return $this->sendResponse($projects, 'Project Data fetch successfully.', 200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendError([], 'Something went wrong', 500);
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
            $project = Project::create([
                'name' => $requestData['name'],
                'description' => $requestData['description'],
                'status' => $requestData['status'],
                'start_date' => $requestData['start_date'],
                'end_date' => $requestData['end_date']
            ]);

            if (isset($requestData['employee_ids'])) {
                $project->employees()->sync($requestData['employee_ids']);
            }

            DB::commit();
            $project->employees_count = $project->employees->count();
         
            return $this->sendResponse($project, 'Record created Successfully', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());
            return $this->sendError([], 'Something went wrong', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
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
            $project = Project::findOrFail($id);
            $project->update([
                'name' => $requestData['name'],
                'description' => $requestData['description'],
                'status' => $requestData['status'],
                'start_date' => $requestData['start_date'],
                'end_date' => $requestData['end_date']
            ]);

            if (isset($requestData['employee_ids'])) {
                $project->employees()->sync($requestData['employee_ids']);
            }

            DB::commit();
            $project->employees_count = $project->employees->count();
         
            return $this->sendResponse($project, 'Record updated Successfully', 200);
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
            $project = Project::findOrFail($id);
            $project->delete();

            return $this->sendResponse($project, 'Record Deleted Successfully', 200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendError([], 'Something went wrong', 500);
        }
    }
}
