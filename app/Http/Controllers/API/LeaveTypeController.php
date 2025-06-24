<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveType;

class LeaveTypeController extends Controller
{
    public function index()
    {
        return LeaveType::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'max_days' => 'nullable|integer'
        ]);

        $leaveType = LeaveType::create($request->all());

        return response()->json($leaveType, 201);
    }
}
