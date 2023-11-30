<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $table = 'posts';

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = ['author', 'category', 'content'];

    // Relacionamentos, se aplicável
    // Exemplo: Um post pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}