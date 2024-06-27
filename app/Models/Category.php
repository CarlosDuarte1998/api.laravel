<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];
    protected $allowIncludes = ['posts', 'posts.user'];
    protected $allowFilter = ['id','name', 'slug'];

    //Relación uno a muchos
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncludes)||empty(request('included'))) {
            return;
        }
        $relations= explode( ',', request('included'));
        $allowIncludes = collect($this->allowIncludes);
        foreach ($relations as $key => $relation) {
            if (!$allowIncludes->contains($relation)) {
                unset($relations[$key]);
            }
        }
        $query->with($relations);
    }

   public function scopeFilter(Builder $query)
{
    if (empty($this->allowFilter) || empty(request('filter'))) {
        return $query;
    }

    $filters = request('filter');
    $allowFilter = collect($this->allowFilter)->filter(function ($field) use ($filters) {
        return array_key_exists($field, $filters);
    });

    $allowFilter->each(function ($field) use ($filters, $query) {
        $query->where($field, 'LIKE', '%' . $filters[$field] . '%');
    });

    return $query;
}
    
    
}
