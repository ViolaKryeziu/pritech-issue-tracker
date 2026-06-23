<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $issue->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        <div class="bg-white p-6 rounded shadow">

            <p class="mb-4">{{ $issue->description }}</p>

            <div class="text-sm text-gray-500">Status: {{ $issue->status }}</div>
            <div class="text-sm text-gray-500">Priority: {{ $issue->priority }}</div>
            <div class="text-sm text-gray-500">Due Date: {{ $issue->due_date ?? 'N/A' }}</div>
            <div class="text-sm text-gray-500">Project: {{ $issue->project->name }}</div>

            {{-- ================= TAGS ================= --}}
            <div class="mt-6">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-gray-700">Tags</h3>

                    <select id="tagSelect"
                            class="border rounded px-2 py-1 text-sm"
                            onchange="attachTag(this.value)">
                        <option value="">+ Add tag</option>

                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="tag-container" class="flex gap-2 flex-wrap">

                    @forelse($issue->tags as $tag)
                        <span id="tag-{{ $tag->id }}"
                              class="px-3 py-1 bg-gray-200 rounded-full text-sm flex items-center gap-2">

                            {{ $tag->name }}

                            <button onclick="detachTag({{ $tag->id }})"
                                    class="text-red-600 text-xs">x</button>
                        </span>
                    @empty
                        <span id="no-tags" class="text-sm text-gray-400">
                            No tags assigned
                        </span>
                    @endforelse
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="mt-6 flex gap-3">
                <a href="{{ route('issues.edit', $issue) }}"
                   class="px-4 py-2 bg-yellow-500 rounded">
                    Edit
                </a>

                <a href="{{ route('issues.index') }}"
                   class="px-4 py-2 bg-gray-600 text-white rounded">
                    Back
                </a>
            </div>

        </div>
    </div>

    <script>
        const issueId = {{ $issue->id }};

        function attachTag(tagId) {
            if (!tagId) return;

            fetch(`/issues/${issueId}/tags/attach`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ tag_id: tagId })
            })
            .then(res => res.json())
            .then(data => {

                const tag = data.tag;

                document.getElementById('no-tags')?.remove();

                if (document.getElementById(`tag-${tag.id}`)) return;

                document.getElementById('tag-container').innerHTML += `
                    <span id="tag-${tag.id}" class="px-3 py-1 bg-gray-200 rounded-full text-sm flex items-center gap-2">
                        ${tag.name}
                        <button onclick="detachTag(${tag.id})" class="text-red-600 text-xs">x</button>
                    </span>
                `;
            });

            document.getElementById('tagSelect').value = '';
        }

        function detachTag(tagId) {
            fetch(`/issues/${issueId}/tags/detach`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ tag_id: tagId })
            })
            .then(res => res.json())
            .then(() => {
                document.getElementById(`tag-${tagId}`)?.remove();

                if (!document.querySelector('#tag-container span')) {
                    document.getElementById('tag-container').innerHTML =
                        `<span class="text-sm text-gray-400">No tags assigned</span>`;
                }
            });
        }
    </script>
</x-app-layout>