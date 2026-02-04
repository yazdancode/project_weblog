<?php

namespace App\Http\Controllers\Admin;
use App\Post;
use App\Category;
use App\Http\Requests\Admin\CategoryRequest;
use JetBrains\PhpStorm\NoReturn;


class PostController extends AdminController
{
    public function index(): null
    {
        $posts = Post::all();
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {

    }

    #[NoReturn]
    public function store(): null
    {

    }

    public function edit($id)
    {
    }

    public function update($id)
    {
    }

    public function destroy($id)
    {
    }
}