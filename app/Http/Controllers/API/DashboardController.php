<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use App\Models\Task;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $dashboardData = [];
            $dashboardData['employees'] = Employee::count();
            $dashboardData['departments'] = Department::count();
            $dashboardData['skills'] = Skill::count();
            $dashboardData['roles'] = Role::count();
            $dashboardData['projects'] = Project::count();
            $dashboardData['tasks'] = Task::count();
            return $this->sendResponse($dashboardData, 'Dashboard data fetch successfully.', 200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendResponse($dashboardData, 'Something went wrong');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
