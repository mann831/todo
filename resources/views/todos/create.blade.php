
@extends('todos.layout')

@section('title', 'Add Task - TaskFlow')
@section('page-heading', 'Add New Task')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('todos.index') }}"
           class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            ← Back to Tasks
        </a>

        <h1 class="text-2xl font-bold text-slate-900 mt-4">
            Create New Task
        </h1>

        <p class="text-slate-500 mt-1">
            Fill in the details below to add a new task.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">

        <form action="{{ route('todos.store') }}" method="POST">
            @csrf

            <div class="mb-6">

                <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">
                    Task Title
                </label>

                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title') }}"
                       placeholder="Enter your task title"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                @error('title')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @else
                    <p class="text-xs text-slate-400 mt-2">
                        Give your task a short and meaningful title.
                    </p>
                @enderror

            </div>

            <div class="mb-6">

                <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                    Description
                </label>

                <textarea id="description"
                          name="description"
                          rows="5"
                          placeholder="Write task description..."
                          class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>

                @error('description')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-8">

                <label for="is_completed" class="block text-sm font-semibold text-slate-700 mb-2">
                    Task Status
                </label>

                <select id="is_completed"
                        name="is_completed"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white outline-none focus:ring-2 focus:ring-indigo-500">

                    <option value="0" @selected(old('is_completed', '0') === '0')>Pending</option>
                    <option value="1" @selected(old('is_completed') === '1')>Completed</option>

                </select>

                @error('is_completed')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror

            </div>

            <div class="flex flex-col sm:flex-row gap-3">

                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold">
                    + Create Task
                </button>

                <a href="{{ route('todos.index') }}"
                   class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-semibold text-center">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
