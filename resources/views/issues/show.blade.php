<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $issue->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        <div class="bg-white p-6 rounded shadow">

            <p>{{ $issue->description }}</p>

            <div class="text-sm text-gray-500 mt-4">
                Status: {{ $issue->status }}
            </div>

            <div class="text-sm text-gray-500">
                Priority: {{ $issue->priority }}
            </div>

            <div class="text-sm text-gray-500">
                Due Date: {{ $issue->due_date ?? 'N/A' }}
            </div>

            <div class="text-sm text-gray-500">
                Project: {{ $issue->project->name }}
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('issues.edit', $issue) }}"
                   class="px-4 py-2 bg-yellow-500 text-white rounded">
                    Edit
                </a>

                <a href="{{ route('issues.index') }}"
                   class="px-4 py-2 bg-gray-600 text-white rounded">
                    Back
                </a>
            </div>

        </div>

    </div>
</x-app-layout>