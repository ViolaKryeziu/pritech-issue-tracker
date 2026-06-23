<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tags
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- CREATE TAG FORM --}}
        <div class="bg-white shadow rounded p-4 mb-4">

            <form method="POST"
                  action="{{ route('tags.store') }}"
                  class="flex flex-wrap gap-4 items-center">

                @csrf

                <input name="name"
                       placeholder="Tag name"
                       class="border-gray-300 rounded-md shadow-sm">

                <input name="color"
                       placeholder="Color (optional)"
                       class="border-gray-300 rounded-md shadow-sm">

                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-black rounded">
                    Add Tag
                </button>

            </form>

        </div>

        {{-- TAG LIST --}}
        <div class="bg-white shadow rounded p-4">

            @forelse($tags as $tag)

                <div class="border-b py-3 flex justify-between items-center">

                    <div class="flex items-center gap-3">

                        <span class="text-lg font-bold">
                            {{ $tag->name }}
                        </span>

                        @if($tag->color)
                            <span class="text-sm text-gray-500">
                                ({{ $tag->color }})
                            </span>
                        @endif

                    </div>

                    <form method="POST"
                          action="{{ route('tags.destroy', $tag) }}">
                        @csrf
                        @method('DELETE')

                        <button class="text-red-600">
                            Delete
                        </button>
                    </form>

                </div>

            @empty

                <p class="text-gray-500">
                    No tags found.
                </p>

            @endforelse

        </div>

    </div>
</x-app-layout>
