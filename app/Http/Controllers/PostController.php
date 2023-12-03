<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage; //php artisan storage:link = php artisan storage:link = http://127.0.0.1:8000/storage/1.jpg
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
        $post = new Post();
        $post->author = $request->author;
        $post->category = $request->category;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $imageName); // Salvar no diretório 'public/images'
            $post->image = $imageName; // Atualizado para o nome do arquivo
        }

        $post->save();

        return response()->json(['message' => 'Post criado com sucesso']);
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
