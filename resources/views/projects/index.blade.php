<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Projects
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="mb-4">
            <a href="{{ route('projects.create') }}"
               class="px-4 py-2 bg-blue-600 text-black rounded">
                + Create Project
            </a>
        </div>

        <div class="bg-white shadow rounded p-4">
            @foreach($projects as $project)
                <div class="border-b py-3 flex justify-between items-center">

                    <div>
                        <h3 class="text-lg font-bold">
                            {{ $project->name }}
                        </h3>

                        <p class="text-sm text-gray-500">
                            {{ Str::limit($project->description, 100) }}
                        </p>
                    </div>

                    <div class="flex gap-2 items-center">

                        <a href="{{ route('projects.show', $project) }}"
                           class="text-blue-600">
                            View
                        </a>

                        @can('update', $project)
                            <a href="{{ route('projects.edit', $project) }}"
                               class="text-yellow-600">
                                Edit
                            </a>
                        @endcan

                        @can('delete', $project)
                            <form method="POST"
                                  action="{{ route('projects.destroy', $project) }}"
                                  onsubmit="return confirm('Are you sure you want to delete this project?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-red-600">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $projects->links() }}
        </div>

    </div>
</x-app-layout>