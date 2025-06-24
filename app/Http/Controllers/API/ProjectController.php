<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::with('tasks')->get();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:projects,name',
                'description' => 'nullable|string',
            ]);

            $project = Project::create($request->only('name', 'description'));

            return response()->json([
                'data' => $project,
                'message' => 'Project created successfully'
            ], 201);
        } catch (Exception $e) {
            $firstError = collect($e->errors())->flatten()->first();
            return response()->json([
                'message' => $firstError
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
