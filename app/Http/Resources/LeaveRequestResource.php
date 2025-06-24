<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'employee'      => [
                'id'    => $this->employee->id,
                'name'  => $this->employee->name,
                'email' => $this->employee->email,
            ],
            'leave_type'    => [
                'id'   => $this->leaveType->id,
                'name' => $this->leaveType->name,
            ],
            'from_date'     => $this->from_date,
            'to_date'       => $this->to_date,
            'reason'        => $this->reason,
            'status'        => $this->status,
            'created_at'    => $this->created_at->toDateTimeString(),
            'updated_at'    => $this->updated_at->toDateTimeString(),
        ];
    }
}
