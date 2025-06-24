<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Http\Resources\LeaveRequestResource;

class LeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with(['employee', 'leaveType']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->leave_type_id) {
            $query->where('leave_type_id', $request->leave_type_id);
        }

        return LeaveRequestResource::collection($query->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $leaveRequest = LeaveRequest::create($request->all());
        return new LeaveRequestResource($leaveRequest->load(['employee', 'leaveType']));
    }

    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);

        $leaveRequest->update(['status' => $request->status]);
        return new LeaveRequestResource($leaveRequest->load(['employee', 'leaveType']));
    }
}
