<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskController extends Controller
{
    public function index()
    {
        $user = $this->user();

        return Task::where('user_id', $user->id)->get();
    }

    public function store(Request $request)
    {
        $user      = $this->user();
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = $user->tasks()->create($validated);

        return response()->json($task, 201);
    }

    public function show (Task $task)
    {
        $user = $this->user();

        if ($task->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $task;
    }

    public function update(Request $request, Task $task)
    {
        $user = $this->user();

        if ($task->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed'   => 'required|boolean',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $user = $this->user();

        if ($task->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $task->delete();

        return response()->json(null, 204);
    }

    private function user()
    {
        return JWTAuth::parseToken()->authenticate();
    }
}
