<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch todos for the authenticated user
        $todos = Todo::where('user_id', auth()->id())->get();

        // Pass todos to the Dashboard view
        return Inertia::render('Dashboard', [
            'todos' => $todos,
        ]);
    }

    public function updateStatus(Request $request, Todo $todo)
    {
        // Ensure the authenticated user owns the todo
        if ($todo->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        // Validate the status input
        $request->validate([
            'status' => 'required|string|in:Pending,In Progress,In Testing,Complete',
        ]);
        // Update the status
        $todo->update(['status' => $request->status]);
        return response()->json(['message' => 'Todo status updated successfully.']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        $todo = Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->completed ?? false,
            'user_id' => auth()->id(), // Ensure the todo is linked to the authenticated user
        ]);

        return redirect()->back()->with('success', 'Todo created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        // Ensure the authenticated user owns the todo
        if ($todo->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully.']);
    }
}
