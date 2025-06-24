<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return Employee::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'designation' => 'nullable|string',
        ]);

        $employee = Employee::create($request->all());

        return response()->json($employee, 201);
    }

    public function showLeaves($id)
    {
        return LeaveRequest::with('leaveType')->where('employee_id', $id)->get();
    }
}
