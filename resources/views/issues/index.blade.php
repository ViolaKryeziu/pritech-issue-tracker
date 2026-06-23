<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Issues
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="mb-4 flex justify-between items-center">
            <a href="{{ route('issues.create') }}"
               class="px-4 py-2 bg-blue-600 text-black rounded">
                + Create Issue
            </a>
        </div>

        {{-- FILTERS --}}
        <div class="bg-white shadow rounded p-4 mb-4">
            <form method="GET"
                  action="{{ route('issues.index') }}"
                  class="flex flex-wrap gap-4 items-center">

                {{-- STATUS --}}
                <select name="status"
                        class="border-gray-300 rounded-md shadow-sm">
                    <option value="">All Statuses</option>
                    <option value="open" @selected(request('status')=='open')>Open</option>
                    <option value="in_progress" @selected(request('status')=='in_progress')>In Progress</option>
                    <option value="closed" @selected(request('status')=='closed')>Closed</option>
                </select>

                {{-- PRIORITY --}}
                <select name="priority"
                        class="border-gray-300 rounded-md shadow-sm">
                    <option value="">All Priorities</option>
                    <option value="low" @selected(request('priority')=='low')>Low</option>
                    <option value="medium" @selected(request('priority')=='medium')>Medium</option>
                    <option value="high" @selected(request('priority')=='high')>High</option>
                </select>

                {{-- TAG FILTER (NEW) --}}
                <select name="tag"
                        class="border-gray-300 rounded-md shadow-sm">
                    <option value="">All Tags</option>

                    @foreach(\App\Models\Tag::all() as $tag)
                        <option value="{{ $tag->id }}"
                            @selected(request('tag') == $tag->id)>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-black rounded">
                    Filter
                </button>

                <a href="{{ route('issues.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded">
                    Reset
                </a>
            </form>
        </div>

        {{-- LIST --}}
        <div class="bg-white shadow rounded p-4">

            @forelse($issues as $issue)

                <div class="border-b py-3 flex justify-between items-center">

                    <div>
                        <h3 class="text-lg font-bold">
                            {{ $issue->title }}
                        </h3>

                        <p class="text-sm text-gray-500">
                            Project: {{ $issue->project->name }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ ucfirst(str_replace('_',' ', $issue->status)) }}
                            |
                            {{ ucfirst($issue->priority) }}
                        </p>

                        {{-- show tags --}}
                        <div class="flex gap-1 mt-1 flex-wrap">
                            @foreach($issue->tags as $tag)
                                <span class="text-xs bg-gray-200 px-2 py-1 rounded">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('issues.show', $issue) }}"
                           class="text-blue-600">View</a>

                        <a href="{{ route('issues.edit', $issue) }}"
                           class="text-yellow-600">Edit</a>

                        <form method="POST"
                              action="{{ route('issues.destroy', $issue) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="text-red-600">
                                Delete
                            </button>
                        </form>
                    </div>

                </div>

            @empty
                <p class="text-gray-500">No issues found.</p>
            @endforelse

        </div>

        <div class="mt-4">
            {{ $issues->withQueryString()->links() }}
        </div>

    </div>
</x-app-layout>