<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::orderBy('group')->orderBy('key')->paginate(20);

        return view('admin.contents.index', compact('contents'));
    }

    public function create()
    {
        return view('admin.contents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:100', 'unique:contents,key'],
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'type' => ['required', 'string', 'max:20'],
            'group' => ['required', 'string', 'max:50'],
            'is_active' => ['boolean'],
        ]);

        Content::create($validated);

        return redirect()->route('admin.contents.index')->with('success', 'Content created successfully.');
    }

    public function edit(Content $content)
    {
        return view('admin.contents.edit', compact('content'));
    }

    public function update(Request $request, Content $content)
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:100', 'unique:contents,key,'.$content->id],
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'type' => ['required', 'string', 'max:20'],
            'group' => ['required', 'string', 'max:50'],
            'is_active' => ['boolean'],
        ]);

        $content->update($validated);

        return redirect()->route('admin.contents.index')->with('success', 'Content updated successfully.');
    }

    public function destroy(Content $content)
    {
        $content->delete();

        return redirect()->route('admin.contents.index')->with('success', 'Content deleted.');
    }
}
