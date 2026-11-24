
@extends('todos.layout')

@section('title', 'My Tasks - TaskFlow')
@section('page-heading', 'My Tasks')

@section('content')

<!-- Welcome Section -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">My Todo List</h1>
        <p class="text-slate-500 mt-1">Organize your work and stay productive.</p>
    </div>

    <a href="{{ route('todos.create') }}"
       class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl font-semibold shadow-sm">
        <span>+</span> Add New Task
    </a>

</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <p class="text-sm text-slate-500 font-medium">Total Tasks</p>
        <h2 class="text-3xl font-bold mt-2">{{ $totalCount }}</h2>
        <p class="text-xs text-slate-400 mt-2">All your tasks</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <p class="text-sm text-slate-500 font-medium">Completed Tasks</p>
        <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $completedCount }}</h2>
        <p class="text-xs text-slate-400 mt-2">Tasks finished</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <p class="text-sm text-slate-500 font-medium">Pending Tasks</p>
        <h2 class="text-3xl font-bold text-amber-500 mt-2">{{ $pendingCount }}</h2>
        <p class="text-xs text-slate-400 mt-2">Tasks remaining</p>
    </div>

</div>

<!-- Todo Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row justify-between gap-4">

        <div>
            <h2 class="text-lg font-bold">All Tasks</h2>
            <p class="text-sm text-slate-500 mt-1">Manage your daily activities.</p>
        </div>

        <form action="{{ route('todos.index') }}" method="GET" class="flex gap-2">
            <input type="text"
                   name="search"
                   value="{{ $search }}"
                   placeholder="Search tasks..."
                   class="border border-slate-300 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500">

            <button type="submit"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium">
                Search
            </button>
        </form>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-left">

            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-4">#</th>
                    <th class="px-6 py-4">Task Title</th>
                    <th class="px-6 py-4">Description</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Created Date</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 text-sm">

                @forelse ($todos as $todo)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-5">{{ $todo->id }}</td>

                        <td class="px-6 py-5 font-semibold text-slate-800">
                            {{ $todo->title }}
                        </td>

                        <td class="px-6 py-5 text-slate-500">
                            {{ \Illuminate\Support\Str::limit($todo->description ?? '-', 50) }}
                        </td>

                        <td class="px-6 py-5">
                            @if ($todo->is_completed)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Completed
                                </span>
                            @else
                                <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Pending
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-5 text-slate-500">{{ $todo->created_at->format('d M Y') }}</td>

                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('todos.show', $todo) }}"
                                   class="text-indigo-600 hover:text-indigo-800 font-medium">View</a>

                                <a href="{{ route('todos.edit', $todo) }}"
                                   class="text-green-600 hover:text-green-800 font-medium">Edit</a>

                                <form action="{{ route('todos.destroy', $todo) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this task?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-slate-500">
                            @if ($search !== '')
                                No tasks match "{{ $search }}".
                            @else
                                No tasks yet. Click "Add New Task" to create your first one.
                            @endif
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    <div class="p-5 border-t border-slate-200 text-sm text-slate-500">
        {{ $todos->links() }}
    </div>

</div>

@endsection
