<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $roles = Role::withCount('employees')->get();
            return $this->sendResponse($roles, 'Role Data fetch successfully.',200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendError([], 'ROle Data fetch successfully.',500);
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
            'role' => 'required|string|max:255'
        ]);
        try {
            $skill = Role::create(['name' => $requestData['role']]);
            $skill->employees_count = $skill->employees->count();
            return $this->sendResponse($skill, 'Record Created Successfully', 200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendResponse([], 'Something went wrong', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $requestData = $request->validate([
            'role' => 'required|string|max:255'
        ]);

        try {
            $role = Role::findOrFail($id);

            $role->update([
                'name' => $requestData['role']
            ]);
           $role->employees_count = $role->employees->count();
            return $this->sendResponse($role, 'Record Updated Successfully', 200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendResponse([], 'Something went wrong', 500);
}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return $this->sendResponse($role, 'Record Deleted Successfully', 200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendResponse([], 'Something went wrong', 500);
        }
    
    }
}
