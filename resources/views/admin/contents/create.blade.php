<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Create Content</h2></x-slot>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.contents.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3"><label class="form-label">Key</label><input type="text" name="key" class="form-control" required placeholder="e.g. homepage_hero_title"></div>
                    <div class="col-md-4 mb-3"><label class="form-label">Title</label><input type="text" name="title" class="form-control"></div>
                    <div class="col-md-2 mb-3"><label class="form-label">Type</label><select name="type" class="form-select"><option value="text">Text</option><option value="html">HTML</option><option value="markdown">Markdown</option></select></div>
                    <div class="col-md-2 mb-3"><label class="form-label">Group</label><select name="group" class="form-select"><option value="general">General</option><option value="homepage">Homepage</option><option value="about">About</option><option value="contact">Contact</option><option value="footer">Footer</option></select></div>
                    <div class="col-md-12 mb-3"><label class="form-label">Content</label><textarea name="content" class="form-control" rows="5"></textarea></div>
                    <div class="col-md-6 mb-3"><div class="form-check"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" checked><label class="form-check-label" for="is_active">Active</label></div></div>
                </div>
                <div class="d-flex justify-content-end"><a href="{{ route('admin.contents.index') }}" class="btn btn-outline-navy me-2">Cancel</a><button type="submit" class="btn btn-navy">Create</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
