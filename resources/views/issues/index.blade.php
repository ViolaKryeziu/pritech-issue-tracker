<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Issues
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="mb-4">
            <a href="{{ route('issues.create') }}"
               class="px-4 py-2 bg-blue-600 text-black rounded">
                + Create Issue
            </a>
        </div>

        <div class="bg-white shadow rounded p-4">
            @foreach($issues as $issue)
                <div class="border-b py-3 flex justify-between items-center">

                    <div>
                        <h3 class="text-lg font-bold">
                            {{ $issue->title }}
                        </h3>

                        <p class="text-sm text-gray-500">
                            {{ $issue->status }} | {{ $issue->priority }}
                        </p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('issues.show', $issue) }}"
                           class="text-blue-600">
                            View
                        </a>

                        <a href="{{ route('issues.edit', $issue) }}"
                           class="text-yellow-600">
                            Edit
                        </a>

                        <form method="POST" action="{{ route('issues.destroy', $issue) }}">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-600">
                                Delete
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $issues->links() }}
        </div>

    </div>
</x-app-layout>