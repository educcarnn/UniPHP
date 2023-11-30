<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // Retorna todos os posts
        $posts = Post::all();
        return response()->json($posts);
    }

    public function show($id)
    {
        // Retorna um post específico pelo ID
        $post = Post::find($id);
        
        if (!$post) {
            return response()->json(['error' => 'Post não encontrado'], 404);
        }

        return response()->json($post);
    }

    public function store(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'author' => 'required|string',
            'category' => 'required|in:Post,Artigo,Grupo',
            'content' => 'required|string',
            'images.*' => 'image|mimes:jpg,png',
        ]);

        // Salvar o post no banco de dados
        $post = new Post();
        $post->author = $request->author;
        $post->category = $request->category;
        $post->content = $request->content;
        $post->save();

        // Salvar imagens em um diretório local
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                // Lógica adicional para associar a imagem ao post no banco de dados, se necessário
            }
        }

        return response()->json(['success' => 'Post criado com sucesso']);
    }

    public function update(Request $request, $id)
    {
        // Validação dos campos
        $request->validate([
            'author' => 'required|string',
            'category' => 'required|in:Post,Artigo,Grupo',
            'content' => 'required|string',
            'images.*' => 'image|mimes:jpg,png',
        ]);
    
        // Encontrar o post pelo ID
        $post = Post::findOrFail($id);
    
        // Atualizar os campos do post
        $post->author = $request->author;
        $post->category = $request->category;
        $post->content = $request->content;
        $post->save();
    
        // Lógica para atualizar imagens, se necessário
    
        // Retornar resposta JSON
        return response()->json(['message' => 'Post atualizado com sucesso']);
    }
    
    public function destroy($id)
    {
        // Encontrar o post pelo ID
        $post = Post::findOrFail($id);
    
        // Lógica para deletar imagens associadas ao post, se necessário
    
        // Deletar o post
        $post->delete();
    
        // Retornar resposta JSON
        return response()->json(['message' => 'Post deletado com sucesso']);
    }
    
}
