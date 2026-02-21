<?php

namespace App\Http\Controllers;

use App\Models\AgeGroup;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with(['ageGroups' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order');
            }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('departments.index', compact('departments'));
    }

    public function show(Department $department)
    {
        abort_if(! $department->is_active, 404);

        $department->load(['ageGroups' => function ($q) {
            $q->where('is_active', true)->orderBy('sort_order');
        }]);

        return view('departments.show', compact('department'));
    }

    public function showAgeGroup(Department $department, AgeGroup $ageGroup)
    {
        abort_if(! $department->is_active, 404);
        abort_if(! $ageGroup->is_active || $ageGroup->department_id !== $department->id, 404);

        return view('departments.age-group', compact('department', 'ageGroup'));
    }
}
