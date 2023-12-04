<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        try {
            $post = new Post();
            $post->author = $request->author;
            $post->category = $request->category;
            $post->content = $request->content;
    
            if ($request->hasFile('image')) {
                $imageName = Str::random(32) . '.' . $request->image->getClientOriginalExtension();
    
                // Salvar a imagem diretamente em storage/images
                Storage::disk('public')->put('images/' . $imageName, file_get_contents($request->image));
    
                // Atualize para usar o caminho completo do arquivo
                $post->image = 'images/' . $imageName;
            }
    
            $post->save();
    
            return response()->json(['message' => 'Post criado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Algo deu muito errado!'], 500);
        }
    }
    public function update(Request $request, $id)
    {
        // Validação dos campos (podendo ser vazios)
        $request->validate([
            'author' => 'sometimes|string',
            'category' => 'sometimes|in:Post,Artigo,Grupo',
            'content' => 'sometimes|string',
            'images.*' => 'sometimes|image|mimes:jpg,png',
        ]);

        // Encontrar o post pelo ID
        $post = Post::findOrFail($id);

        // Atualizar os campos do post apenas se estiverem presentes na requisição
        $post->fill($request->only(['author', 'category', 'content']));

        // Lógica para atualizar imagens, se necessário
        if ($request->hasFile('images')) {
            // Lógica para processar as imagens
        }

        // Salvar as alterações
        $post->save();

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
