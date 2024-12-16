<?php

namespace App\Http\Controllers\API;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $departments = Skill::withCount('employees')->get();
            return $this->sendResponse($departments, 'Department Data fetch successfully.', 200);
        } catch (\Exception $e) {
            return $this->sendResponse($departments, 'Department Data fetch successfully.', 500);
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
            'skill' => 'required|string|max:255'
        ]);
        try {
            $skill = Skill::create(['name' => $requestData['skill']]);
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
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
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
            $role = Skill::findOrFail($id);

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
            $skill = Skill::findOrFail($id);
            $skill->delete();

            return $this->sendResponse($skill, 'Record Deleted Successfully', 200);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->sendResponse([], 'Something went wrong', 500);
        }
    }
}
