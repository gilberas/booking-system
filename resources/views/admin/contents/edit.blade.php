<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Edit Content — {{ $content->key }}</h2></x-slot>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.contents.update', $content) }}">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-4 mb-3"><label class="form-label">Key</label><input type="text" name="key" class="form-control" value="{{ old('key', $content->key) }}" required></div>
                    <div class="col-md-4 mb-3"><label class="form-label">Title</label><input type="text" name="title" class="form-control" value="{{ old('title', $content->title) }}"></div>
                    <div class="col-md-2 mb-3"><label class="form-label">Type</label><select name="type" class="form-select"><option value="text" {{ $content->type==='text'?'selected':'' }}>Text</option><option value="html" {{ $content->type==='html'?'selected':'' }}>HTML</option><option value="markdown" {{ $content->type==='markdown'?'selected':'' }}>Markdown</option></select></div>
                    <div class="col-md-2 mb-3"><label class="form-label">Group</label><select name="group" class="form-select"><option value="general" {{ $content->group==='general'?'selected':'' }}>General</option><option value="homepage" {{ $content->group==='homepage'?'selected':'' }}>Homepage</option><option value="about" {{ $content->group==='about'?'selected':'' }}>About</option><option value="contact" {{ $content->group==='contact'?'selected':'' }}>Contact</option><option value="footer" {{ $content->group==='footer'?'selected':'' }}>Footer</option></select></div>
                    <div class="col-md-12 mb-3"><label class="form-label">Content</label><textarea name="content" class="form-control" rows="5">{{ old('content', $content->content) }}</textarea></div>
                    <div class="col-md-6 mb-3"><div class="form-check"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" {{ old('is_active', $content->is_active) ? 'checked' : '' }}><label class="form-check-label" for="is_active">Active</label></div></div>
                </div>
                <div class="d-flex justify-content-end"><a href="{{ route('admin.contents.index') }}" class="btn btn-outline-navy me-2">Cancel</a><button type="submit" class="btn btn-navy">Update</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
