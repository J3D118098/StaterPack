<?php

namespace App\Http\Controllers\Post;

use App\{Category,Post};
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('post.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $slug = Str::slug($request['name_video'], '-');
        $request["name_video"] = ucwords($request["name_video"]);
        $request['description'] = ucfirst($request['description']);


        $post = Post::create([
            'name_video' => $request['name_video'],
            'category_id' => $request['category_id'],
            'order' => $request['order'],
            "start" => $request['start'],
            "end" => $request['end'],
            "description" => $request["description"],
            "video" => $request['video'],
            'slug' => $slug
        ]);
        return back()->with('success',"Post has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $category = Category::with('posts')->where('id',$post->category_id)->first();
        $link = Str::after($post->video, 'https://www.youtube.com/watch?v=');
        return view('post.show',compact('category','post','link'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

        $categories=Category::with('posts')->get();
        return view('post.edit',compact('post','categories'));
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
        $validasi = $request->validate([
            'name_video' => "required|string|max:25|unique:posts,name_video,".$post->id,
            'category_id' => 'required',
            'order' => [
                    'required',
                    Rule::unique('posts')->where(function ($query){
                        return $query->where('category_id',request('category_id'));

                    })->ignore($post->id),
                ],
            "start" => "nullable|integer",
            "end" => "nullable|integer",
            "description" => 'required|max:255|string',
            "video" => "required|string|max:50|unique:posts,video,".$post->id,
        ]);
        $validasi['slug'] = Str::slug($validasi['name_video'], '-');
        $validasi["name_video"] = ucwords($validasi["name_video"]);
        $validasi['description'] = ucfirst($validasi['description']);
        Post::where('id', $post->id)->update($validasi);
        $request->session()->flash('pesan',"Data berhasil diperbaharui");
        return redirect()->route("post.show", ['post'=> $validasi['slug']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('category.show', ['category'=> $post->category->slug])
        ->with('pesan',"Data berhasil dihapus");
    }
}
