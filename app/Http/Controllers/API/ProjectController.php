<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::with('tasks')->get();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        return Project::create($request->only('name', 'description'));
    }
}
