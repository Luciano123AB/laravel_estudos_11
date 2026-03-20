<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class MainController extends Controller
{
    public function index(): View {

        //Get all posts the data of the user who create the post:
        $posts = Post::with("user")->get();

        return view("dashboard", ["posts" => $posts]);
    }
    public function createPost() {
        //Gate:
        if (Gate::denies("post.create")) {
            abort(403, "Você não tem permissão para criar posts.");
        }

        echo "Create Post!";
    }
    public function deletePost($id) {

        $post = Post::find($id);

        //Gate:
        if (Gate::denies("post.delete", $post)) {
            abort(403, "Você não tem permissão para eliminar um post.");
        }

        echo "Delete Post!";
    }
}
