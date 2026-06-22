<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Issue
        </h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto">

        <form method="POST"
              action="{{ route('issues.update', $issue) }}"
              class="bg-white shadow-md rounded-lg p-6 border border-gray-200">

            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Title
                </label>

                <input
                    name="title"
                    value="{{ old('title', $issue->title) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Description
                </label>

                <textarea
                    name="description"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $issue->description) }}</textarea>

                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Project
                </label>

                <select
                    name="project_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                    @foreach($projects as $project)
                        <option value="{{ $project->id }}"
                            @selected(old('project_id', $issue->project_id) == $project->id)>
                            {{ $project->name }}
                        </option>
                    @endforeach

                </select>

                @error('project_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                    <option value="open" @selected($issue->status === 'open')>Open</option>
                    <option value="in_progress" @selected($issue->status === 'in_progress')>In Progress</option>
                    <option value="closed" @selected($issue->status === 'closed')>Closed</option>

                </select>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Priority
                </label>

                <select
                    name="priority"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                    <option value="low" @selected($issue->priority === 'low')>Low</option>
                    <option value="medium" @selected($issue->priority === 'medium')>Medium</option>
                    <option value="high" @selected($issue->priority === 'high')>High</option>

                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Due Date
                </label>

                <input
                    type="date"
                    name="due_date"
                    value="{{ old('due_date', $issue->due_date) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="px-5 py-2 bg-indigo-700 text-black font-semibold rounded-md shadow-md hover:bg-indigo-800 transition">
                    Update Issue
                </button>
            </div>

        </form>

    </div>
</x-app-layout>