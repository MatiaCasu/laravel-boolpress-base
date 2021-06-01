<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    //Validazioni in array globale
    protected $validation = [
        'date' => 'required|date',
        'content' => 'required|string',
        'image' => 'nullable|max:2048'
        //Validazioni mimer non riconoscono file jpg
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('updated_at','desc')->get();

        return view('admin.posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();

        return view('admin.posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $this->validation;
        $validation['title'] = 'required|string|max:255|unique:posts';
        
        $request->validate($validation);

        $data = $request->all();

        // checkbox
        $data['public'] = !isset($data['public']) ? 0 : 1;
        
        // slug
        $data['slug'] = Str::slug($data['title'], '-');

        if( isset($data['image']) ) {
            $data['image'] = Storage::disk('public')->put('images', $data['image']);
        }

        $newPost = Post::create($data);    
        
        // tags
        if( isset($data['tags']) ) {
            $newPost->tags()->attach($data['tags']);
        }

        return redirect()->route('admin.posts.index');
    }
 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'tags'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validation = $this->validation;
        $validation['title'] = 'required|string|max:255|unique:posts,title,' . $post->id;

        $request->validate($validation);

        $data = $request->all();

        $data['public'] = !isset($data['public']) ? 0 : 1;
        $data['slug'] = Str::slug($data['title'], '-');

        $post->update($data);

        if( !isset($data['tags']) ) {
            $data['tags'] = [];
        }
        $post->tags()->sync($data['tags']);

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('message', 'Post eliminato');
    }
}
