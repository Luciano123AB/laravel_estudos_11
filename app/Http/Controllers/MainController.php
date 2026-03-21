<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return view("create-post");
    }

    public function storePost(Request $request) {
        //Gate:
        if (Gate::denies("post.create")) {
            abort(403, "Você não tem permissão para criar posts.");
        }

        $request->validate(
            [
                "title" => "required|min:3|max:100",
                "content" => "required|min:3|max:1000"
            ],

            [
                "title.required" => "O campo título é obrigatório.",
                "title.min" => "O campo título deve ter no mínimo :min caracteres.",
                "title.max" => "O campo título deve ter no máximo :max caracteres.",
                "content.required" => "O campo conteúdo é obrigatório.",
                "content.min" => "O campo conteúdo deve ter no mínimo :min caracteres.",
                "content.max" => "O campo conteúdo deve ter no máximo :max caracteres."
            ]
        );

        //Create the post:
        Post::create([
            "title" => $request->title,
            "content" => $request->content,
            "user_id" => Auth::user()->id
        ]);

        return redirect()->route("dashboard");
    }
    
    public function deletePost($id) {

        $post = Post::find($id);

        //Gate:
        if (Gate::denies("post.delete", $post)) {
            abort(403, "Você não tem permissão para eliminar um post.");
        }

        //Delete the post:
        $post->delete();

        return redirect()->route("dashboard");
    }
}
