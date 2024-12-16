<?php

namespace App\Http\Controllers\API;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\BaseController;

class EmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $employees = Employee::select('id', 'name', 'email', 'phone', 'date_of_birth', 'joining_date', 'department_id')->with('department')->with('roles')->get();
            return $this->sendResponse($employees, 'Employee Data fetch successfully.', 200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendError($employees, 'Employee Data fetch successfully.', 500);
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
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'joining_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'role_ids' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $employee = Employee::create([
                'name' => $requestData['name'],
                'email' => $requestData['email'],
                'phone' => $requestData['phone'],
                'date_of_birth' => $requestData['date_of_birth'],
                'joining_date' => $requestData['joining_date'],
                'department_id' => $requestData['department_id'],
            ]);

            if (isset($requestData['role_ids'])) {
                $employee->roles()->sync($requestData['role_ids']);
            }

            DB::commit();
            return $this->sendResponse($employee->load('department', 'roles'), 'Record created Successfully', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());
            return $this->sendError($requestData, 'Something went wrong', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'joining_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'role_ids' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $employee = Employee::findOrFail($id);

            $employee->update([
                'name' => $requestData['name'],
                'phone' => $requestData['phone'],
                'date_of_birth' => $requestData['date_of_birth'],
                'joining_date' => $requestData['joining_date'],
                'department_id' => $requestData['department_id'],
            ]);

            if (isset($requestData['role_ids'])) {
                $employee->roles()->sync($requestData['role_ids']);
            }

            DB::commit();
            return $this->sendResponse($employee->load('department', 'roles'), 'Record Updated Successfully', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());
            return $this->sendError($requestData, 'Something went wrong', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return $this->sendResponse($employee, 'Record Deleted Successfully', 200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendError([], 'Something went wrong', 500);
        }
    }
}
