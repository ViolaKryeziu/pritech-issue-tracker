<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        <div class="bg-white p-6 rounded shadow mb-6">
            <p>{{ $project->description }}</p>

            <div class="text-sm text-gray-500 mt-2">
                Start: {{ $project->start_date }} |
                Deadline: {{ $project->deadline }}
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow">

            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-bold">Issues</h3>

                <a href="#"
                   class="px-3 py-1 bg-blue-600 text-white rounded">
                    + Add Issue
                </a>
            </div>

            @forelse($project->issues as $issue)
                <div class="border-b py-2">
                    <h4 class="font-semibold">{{ $issue->title }}</h4>
                    <p class="text-sm text-gray-500">
                        {{ $issue->status }} | {{ $issue->priority }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500">No issues yet</p>
            @endforelse

        </div>

    </div>
</x-app-layout>