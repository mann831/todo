<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TodoController extends Controller
{
    /**
     * Show the list of todos, with optional search and the summary counts.
     */
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $todos = Todo::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('todos.index', [
            'todos' => $todos,
            'search' => $search,
            'totalCount' => Todo::query()->count(),
            'completedCount' => Todo::query()->where('is_completed', true)->count(),
            'pendingCount' => Todo::query()->where('is_completed', false)->count(),
        ]);
    }

    /**
     * Show the form for creating a new todo.
     */
    public function create(): View
    {
        return view('todos.create');
    }

    /**
     * Save a new todo to the database.
     */
    public function store(StoreTodoRequest $request): RedirectResponse
    {
        Todo::query()->create($request->validated());

        return redirect()
            ->route('todos.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Show one todo.
     */
    public function show(Todo $todo): View
    {
        return view('todos.show', ['todo' => $todo]);
    }

    /**
     * Show the form for editing a todo.
     */
    public function edit(Todo $todo): View
    {
        return view('todos.edit', ['todo' => $todo]);
    }

    /**
     * Save the changes to an existing todo.
     */
    public function update(UpdateTodoRequest $request, Todo $todo): RedirectResponse
    {
        $todo->update($request->validated());

        return redirect()
            ->route('todos.show', $todo)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Delete a todo from the database.
     */
    public function destroy(Todo $todo): RedirectResponse
    {
        $todo->delete();

        return redirect()
            ->route('todos.index')
            ->with('success', 'Task deleted successfully.');
    }
}
