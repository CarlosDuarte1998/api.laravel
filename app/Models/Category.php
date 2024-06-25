<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];
    protected $allowedIncludes = ['posts', 'posts.user'];

    //Relación uno a muchos
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowedIncludes)||empty(request('included'))) {
            return;
        }
        $relations= explode( ',', request('included'));
        $allowedIncludes = collect($this->allowedIncludes);
        foreach ($relations as $key => $relation) {
            if (!$allowedIncludes->contains($relation)) {
                unset($relations[$key]);
            }
        }
        $query->with($relations);
    }
    
}
