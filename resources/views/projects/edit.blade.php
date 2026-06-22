<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Project
        </h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto">

        <form method="POST"
              action="{{ route('projects.update', $project) }}"
              class="bg-white shadow-md rounded-lg p-6 border border-gray-200">

            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Name
                </label>

                <input name="name"
                    value="{{ old('name', $project->name) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Description
                </label>

                <textarea name="description"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $project->description) }}</textarea>
            </div>

            <!-- Start Date -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Start Date
                </label>

                <input type="date"
                    name="start_date"
                    value="{{ old('start_date', $project->start_date) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Deadline -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Deadline
                </label>

                <input type="date"
                    name="deadline"
                    value="{{ old('deadline', $project->deadline) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-5 py-2 bg-indigo-700 text-black font-semibold rounded-md shadow-md hover:bg-indigo-800 transition">
                    Update Project
                </button>
            </div>

        </form>

    </div>
</x-app-layout>