<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\post;
use App\Category;

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
        $posts = Post::all();

        // ciao
        // stessa cosa di function show
        // $categories = Category::all();
        // return view('admin.posts.index', compact('posts', 'categories'));

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // con il request validate nel secondo campo posso specificare il tipo di
        // errore che apparirá a schermo tramite il secondo array vado a definirlo
        $request->validate([
            'title'=> 'required|max:250',
            'content'=> 'required',
            'category_id'=> 'required|exists:categories,id'
        ], [
            'title.max'=> ':attribute puó avere massimo :max caratteri',
            'category_id.required'=> 'Seleziona una categoria'
        ]);
        $postData = $request->all();
        $newPost = new Post();
        $newPost->fill($postData);

        $newPost->slug = Post::convertToSlug($newPost->title);
        $newPost->save();

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
        //

        if(!$post) {
            abort(404);
        }
        $category = Category::find($post->category_id);

        return view('admin.posts.show', compact('post', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        if(!$post){
            abort(404);
        }

        // avendo nominato una funzione category nel modello Category, posso accendere alle 
        // categories utilizzando questa funzione come attributo, perché ho legato 
        // le due tabelle tramite le parole chiave has many e belongs to... 
        // quindi nel show.blade per richiamarla posso direttamente utilizzare
        // $post->category->name 
        // return view('admin.posts.edit', compact('post'));

        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
        
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
        //
        $request->validate([
            'title'=> 'required|max:250',
            'content'=> 'required',
            'category_id'=> 'required|exists:categories,id'
        ], [
            'title.max'=> ':attribute puó avere massimo :max caratteri',
            'category_id.required'=> 'Seleziona una categoria'
        ]);
        $postData = $request->all();

        $post->fill($postData);

        $post->slug = Post::convertToSlug($post->title);
        $post->update();

        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        if($post) {
            $post->delete();
        }

        return redirect()->route('admin.posts.index');
    }
}
