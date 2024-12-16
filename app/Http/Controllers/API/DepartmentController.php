<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $departments = Department::select('id', 'name', 'created_at')->withCount('employees')->get();
            return $this->sendResponse($departments, 'Department Data fetch successfully.', 200);
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
            'department' => 'required|string|max:255'
        ]);
        try {
            $department = Department::create(['name' => $requestData['department']]);
            $department->employees_count = $department->employees->count();
            return $this->sendResponse($department, 'Record Created Successfully', 200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendError([], 'Something went wrong', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $requestData = $request->validate([
            'department' => 'required|string|max:255'
        ]);

        try {
            $department = Department::findOrFail($id);

            $department->update([
                'name' => $requestData['department']
            ]);
            $department->employees_count = $department->employees->count();
            return $this->sendResponse($department, 'Record Updated Successfully', 200);
        } catch (\Exception $e) {
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
            $department = Department::findOrFail($id);
            $department->delete();

            return $this->sendResponse($department, 'Record Deleted Successfully', 200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendError([], 'Something went wrong', 500);
        }
    }
}
