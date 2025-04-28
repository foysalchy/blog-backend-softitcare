<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    
    public function postlist()
    {
        return Post::with('user', 'categories', 'comments')
                   ->latest()
                   ->paginate(4); // Paginate 3 posts per page
    }
    
    public function index()
    {
        return Post::with('user', 'categories', 'comments')->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'categories'=>'required|array',
            'categories.*'=>'exists:categories,id',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('title', 'content','status');
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
           
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('posts'), $filename);
            $data['image'] = 'posts/' . $filename;
        }
        

        $post = Post::create($data);
        $post->categories()->attach($request->categories);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return $post->load('user', 'categories', 'comments', 'comments.user');
    }

    public function update(Request $request)
    {
       

        $request->validate([
            'title'=>'sometimes|required',
            'content'=>'sometimes|required',
            'status'=>'sometimes',
            'categories'=>'sometimes|array',
            'categories.*'=>'exists:categories,id',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $post=Post::find($request->post_id);
        
            $post->update([
            'title'=>$request->title,
            'content'=>$request->content,
            'status'=>$request->status,
            ]);
        
        if ($request->hasFile('image')) {
           
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('posts'), $filename);
            $post->image = 'posts/' . $filename;
            $post->save();
        }

         

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
      

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
