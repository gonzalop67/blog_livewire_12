<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[ObservedBy(PostObserver::class)]
class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image_path',
        'user_id',
        'category_id',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime'
    ];

    protected function image() : Attribute {
        return Attribute::make(
            get: fn () => $this->image_path ? Storage::url($this->image_path) : 'https://placehold.co/90x160?text=Imagen+Post'
        );
    }

    //Route Model Binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
