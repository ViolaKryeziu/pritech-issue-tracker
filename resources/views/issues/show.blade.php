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

                        <button type="button"
                            onclick="detachTag({{ $tag->id }})"
                            class="text-red-600 text-xs">
                            x
                        </button>
                    </span>
                    @empty
                    <span id="no-tags" class="text-sm text-gray-400">
                        No tags assigned
                    </span>
                    @endforelse

                </div>
            </div>

            {{-- ================= USERS ================= --}}
            <div class="mt-6">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-gray-700">Assigned Users</h3>

                    <select id="userSelect"
                        class="border rounded px-2 py-1 text-sm"
                        onchange="attachUser(this.value)">
                        <option value="">+ Assign user</option>

                        @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div id="user-container" class="flex gap-2 flex-wrap">

                    @forelse($issue->users as $user)
                    <span id="user-{{ $user->id }}"
                        class="px-3 py-1 bg-blue-100 rounded-full text-sm flex items-center gap-2">

                        {{ $user->name }}

                        <button type="button"
                            onclick="detachUser({{ $user->id }})"
                            class="text-red-600 text-xs">
                            x
                        </button>
                    </span>
                    @empty
                    <span id="no-users" class="text-sm text-gray-400">
                        No users assigned
                    </span>
                    @endforelse

                </div>
            </div>

            {{-- ================= COMMENTS ================= --}}
            <div class="mt-8">

                <h3 class="font-bold text-gray-700 mb-3">
                    Comments
                </h3>

                <div id="comment-errors" class="mb-2 text-red-600 text-sm hidden"></div>

                <form id="commentForm">

                    <input
                        type="text"
                        name="author_name"
                        placeholder="Your name"
                        class="border rounded p-2 w-full mb-2">

                    <textarea
                        name="body"
                        rows="3"
                        placeholder="Write a comment..."
                        class="border rounded p-2 w-full"></textarea>

                    <button type="submit"
                        class="mt-2 px-4 py-2 bg-blue-600 text-black rounded">
                        Add Comment
                    </button>

                </form>
                {{-- COMMENTS LIST --}}
                <div id="comments" class="mt-4"></div>
                <div id="comment-pagination" class="flex gap-2 mt-4"></div>

            </div>

            {{-- ACTIONS --}}
            <div class="mt-6 flex gap-3">
                <a href="{{ route('issues.edit', $issue) }}"
                    class="px-4 py-2 bg-yellow-500 rounded">
                    Edit
                </a>

                <a href="{{ route('issues.index') }}"
                    class="px-4 py-2 bg-gray-600 text-black rounded">
                    Back
                </a>
            </div>

        </div>
    </div>

    <script>
        const issueId = {
            {
                $issue - > id
            }
        };

        let nextPageUrl = null;
        let prevPageUrl = null;

        /* ================= TAGS ================= */

        function attachTag(tagId) {
            if (!tagId) return;

            fetch(`/issues/${issueId}/tags/attach`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        tag_id: tagId
                    })
                })
                .then(res => res.json())
                .then(data => {

                    const tag = data.tag;

                    document.getElementById('no-tags')?.remove();

                    if (document.getElementById(`tag-${tag.id}`)) return;

                    document.getElementById('tag-container').innerHTML += `
                    <span id="tag-${tag.id}" class="px-3 py-1 bg-gray-200 rounded-full text-sm flex items-center gap-2">
                        ${tag.name}
                        <button type="button"
                        onclick="detachTag(${tag.id})"
                        class="text-red-600 text-xs">
                        x
                        </button>
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
                    body: JSON.stringify({
                        tag_id: tagId
                    })
                })
                .then(() => {
                    document.getElementById(`tag-${tagId}`)?.remove();

                    if (!document.querySelector('#tag-container span')) {
                        document.getElementById('tag-container').innerHTML =
                            `<span id="no-tags" class="text-sm text-gray-400">No tags assigned</span>`;
                    }
                });
        }

        /* ================= USERS ================= */

        function attachUser(userId) {
            if (!userId) return;

            fetch(`/issues/${issueId}/users/attach`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_id: userId
                    })
                })
                .then(res => res.json())
                .then(data => {

                    const user = data.user;

                    document.getElementById('no-users')?.remove();

                    if (document.getElementById(`user-${user.id}`)) return;

                    document.getElementById('user-container').innerHTML += `
                    <span id="user-${user.id}" class="px-3 py-1 bg-blue-100 rounded-full text-sm flex items-center gap-2">
                        ${user.name}
                        <button type="button" onclick="detachUser(${user.id})" class="text-red-600 text-xs">x</button>
                    </span>
                `;
                });

            document.getElementById('userSelect').value = '';
        }

        function detachUser(userId) {
            fetch(`/issues/${issueId}/users/detach`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_id: userId
                    })
                })
                .then(() => {
                    document.getElementById(`user-${userId}`)?.remove();

                    if (!document.querySelector('#user-container span')) {
                        document.getElementById('user-container').innerHTML =
                            `<span id="no-users" class="text-sm text-gray-400">No users assigned</span>`;
                    }
                });
        }

        /* ================= COMMENTS ================= */

        loadComments();

        function showErrors(errors)
        {
            const box = document.getElementById('comment-errors');
            box.classList.remove('hidden');
            box.innerHTML = Object.values(errors).flat().join('<br>');
        }

        function clearErrors()
    {
            const box = document.getElementById('comment-errors');
            box.classList.add('hidden');
            box.innerHTML = '';
        }

        function loadComments(url = `/issues/${issueId}/comments`)
        {
            fetch(url)
                .then(res => res.json())
                .then(data => {

                    let html = '';

                    data.comments.forEach(comment => {
                        html += `
                            <div class="border rounded p-3 mb-2">
                                <div class="font-semibold">
                                ${comment.author_name}
                                </div>
                                <div>
                                ${comment.body}
                                </div>
                            </div>
                        `;
                    });

                    document.getElementById('comments').innerHTML = html;

                    nextPageUrl = data.next_page_url;
                    prevPageUrl = data.prev_page_url;

                    renderPagination();
                });
        }

        function renderPagination() {
            let html = '';

            if (prevPageUrl) {
                html += `
                <button onclick="loadComments('${prevPageUrl}')"
                        class="px-3 py-1 bg-gray-300 rounded">
                        Previous
                        </button>
                        `;
            }

            if (nextPageUrl) {
                html += `
                <button onclick="loadComments('${nextPageUrl}')"
                        class="px-3 py-1 bg-gray-300 rounded">
                        Next
                        </button>
                        `;
            }

            document.getElementById('comment-pagination').innerHTML = html;
        }

        document.getElementById('commentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(`/issues/${issueId}/comments`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {

                    const comment = data.comment;

                    document.getElementById('comments').innerHTML =
                        `<div class="border rounded p-3 mb-2">
                        <div class="font-semibold">${comment.author_name}</div>
                        <div>${comment.body}</div>
                    </div>` +
                        document.getElementById('comments').innerHTML;

                    document.getElementById('commentForm').reset();
                });
        });
    </script>
</x-app-layout>