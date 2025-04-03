<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth')->except(['index', 'show']);
    }
    
    public function index()
    {
        $posts = BlogPost::orderBy('created_at', 'desc')->paginate(10);
        return view('blog.index', compact('posts'));
    }
    
    public function create()
    {
        return view('blog.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'cover_image' => 'nullable|image|max:2048', 
        ]);
        
        $data = [
            'user_id' => Auth::id(), 
            'title'   => $request->title,
            'content' => $request->content,
        ];
        
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('cover_images', 'public');
        }
        
        BlogPost::create($data);
        
        return redirect()->route('blog.index')->with('success', 'Post created successfully.');
    }
    
    public function show($id)
    {
        $post = BlogPost::findOrFail($id);
        return view('blog.show', compact('post'));
    }
    
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $user = Auth::user();
        
        if ($user->id !== $post->user_id && !$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        return view('blog.edit', compact('post'));
    }
    
    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $user = Auth::user();
        
        if ($user->id !== $post->user_id && !$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);
        
        $data = [
            'title'   => $request->title,
            'content' => $request->content,
        ];
        
        if ($request->hasFile('cover_image')) {
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('cover_images', 'public');
        }
        
        $post->update($data);
        
        return redirect()->route('blog.show', $post->id)->with('success', 'Post updated successfully.');
    }
    
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        $user = Auth::user();
        
        if ($user->id !== $post->user_id && !$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }
        
        $post->delete();
        
        return redirect()->route('blog.index')->with('success', 'Post deleted successfully.');
    }
}
