
@extends('todos.layout')

@section('title', 'Task Details - TaskFlow')
@section('page-heading', 'Task Details')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">

        <a href="{{ route('todos.index') }}"
           class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            ← Back to Tasks
        </a>

        <h1 class="text-2xl font-bold text-slate-900 mt-4">
            Task Details
        </h1>

        <p class="text-slate-500 mt-1">
            View your task information.
        </p>

    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        <!-- Header -->
        <div class="p-6 sm:p-8 border-b border-slate-200">

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">

                <div>
                    <p class="text-sm text-slate-500 mb-2">Task #{{ $todo->id }}</p>

                    <h2 class="text-2xl font-bold text-slate-900">
                        {{ $todo->title }}
                    </h2>
                </div>

                @if ($todo->is_completed)
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold w-fit">
                        Completed
                    </span>
                @else
                    <span class="bg-amber-100 text-amber-700 px-4 py-2 rounded-full text-sm font-semibold w-fit">
                        Pending
                    </span>
                @endif

            </div>

        </div>

        <!-- Task Information -->
        <div class="p-6 sm:p-8 space-y-6">

            <div>
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wide">
                    Description
                </h3>

                <p class="text-slate-700 mt-2 leading-7 whitespace-pre-line">{{ $todo->description ?: 'No description.' }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <div>
                    <h3 class="text-sm font-semibold text-slate-500">
                        Created Date
                    </h3>

                    <p class="text-slate-800 mt-2 font-medium">
                        {{ $todo->created_at->format('d F Y, h:i A') }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-slate-500">
                        Last Updated
                    </h3>

                    <p class="text-slate-800 mt-2 font-medium">
                        {{ $todo->updated_at->format('d F Y, h:i A') }}
                    </p>
                </div>

            </div>

        </div>

        <!-- Footer Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row gap-3">

            <a href="{{ route('todos.edit', $todo) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold text-center">
                Edit Task
            </a>

            <form action="{{ route('todos.destroy', $todo) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this task?');">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold">
                    Delete Task
                </button>
            </form>

            <a href="{{ route('todos.index') }}"
               class="bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 px-6 py-3 rounded-xl font-semibold text-center">
                Back to List
            </a>

        </div>

    </div>

</div>

@endsection
