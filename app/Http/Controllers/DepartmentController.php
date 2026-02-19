<?php

namespace App\Http\Controllers;

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

    public function show(string $slug)
    {
        $department = Department::with(['ageGroups' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order');
            }])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('departments.show', compact('department'));
    }
}
