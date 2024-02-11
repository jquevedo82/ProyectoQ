<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::get();
        return view('posts.index', ['posts' => $posts]);
    }
    public function create(): View
    {
        return view('posts.create', ['post' => new Post]);
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'titulo' => ['required', 'min:1', 'max:30'],
            'texto' => ['required', 'max:250'],
            'imagen' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombre_imagen = 'imagen_' . time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('img', $nombre_imagen, 'public');
        } else {
            $nombre_imagen = null;
        }
        Post::create([
            'titulo' => $request->titulo,
            'texto' => $request->texto,
            'imagen' => $nombre_imagen,
        ]);

        session()->flash('status', 'Post Created!!');

        return to_route('posts.index');
    }
    public function show($postId)
    {
        $post = Post::find($postId);

        if ($post) {
            return view('posts.show', ['post' => $post]);
        } else {

            return view('post.show');
        }
    }
    public function getFavorites(Request $request): View
    {
        $favorites = json_decode($request->input('favorites'), true);

        $filteredPostIds = array_map(function ($favorite) {
            [$postId, $userId] = explode('_', $favorite);
            return ($userId == auth()->id()) ? $postId : null;
        }, $favorites);

        $filteredPostIds = array_filter($filteredPostIds);

        $posts = Post::whereIn('id', $filteredPostIds)->get();

        return view('posts.index', ['posts' => $posts]);
    }
    public function search(Request $request): View
    {
        $query = $request->input('query');
        // Realizar la búsqueda de posts basada en el término de búsqueda
        $searchResults = Post::where('titulo', 'like', '%' . $query . '%')->get();
        return view('posts.search', ['posts' => $searchResults]);

    }
}
