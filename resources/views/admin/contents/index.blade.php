<x-app-layout>
    <x-slot name="header"><div class="d-flex justify-content-between"><h2 class="h4 mb-0">Website Content</h2><a href="{{ route('admin.contents.create') }}" class="btn btn-navy btn-sm">+ New Content</a></div></x-slot>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Key</th><th>Title</th><th>Type</th><th>Group</th><th>Active</th><th></th></tr></thead>
                <tbody>
                    @forelse ($contents as $c)
                        <tr>
                            <td><code>{{ $c->key }}</code></td>
                            <td>{{ $c->title ?? '—' }}</td>
                            <td>{{ $c->type }}</td>
                            <td><span class="badge bg-info">{{ $c->group }}</span></td>
                            <td>{!! $c->is_active ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' !!}</td>
                            <td class="text-end"><a href="{{ route('admin.contents.edit', $c) }}" class="btn btn-sm btn-outline-navy">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No content entries.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $contents->links() }}</div>
</x-app-layout>
