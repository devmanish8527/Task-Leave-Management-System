<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required',
        ]);

        return Task::create([
            'project_id' => $request->project_id,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'status' => $request->status ?? 'todo',
            'due_date' => $request->due_date
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $task->update($request->only('title', 'status', 'due_date'));
        return $task;
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function projectTasks($id)
    {
        $project = Project::findOrFail($id);
        $tasks = Task::where('project_id', $id)->get()->groupBy('status');

        return response()->json([
            'project' => $project,
            'grouped_tasks' => $tasks
        ]);
    }
}
