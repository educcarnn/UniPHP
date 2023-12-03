<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = ['author', 'category', 'content', 'image'];

    public function getImageUrlAttribute()
    {
        $path = $this->attributes['image'];
        return $this->imageUrl($path);
    }

    protected function imageUrl(string $path): string
    {
        return asset('storage/images/' . $path);
    }
}