<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;

trait ApiTrait
{
    
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncludes) || empty(request('included'))) {
            return;
        }
        $relations = explode(',', request('included'));
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

    public function scopeSort(Builder $query)
    {
        if (empty($this->allowSort) || empty(request('sort'))) {
            return $query;
        }

        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);

        foreach ($sortFields as $sortField) {
            $direction = 'asc';
            if (substr($sortField, 0, 1) == '-') {
                $direction = 'desc';
                $sortField = substr($sortField, 1);
            }
            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direction);
            }
        }
    }

    public function scopeGetOrPaginate(Builder $query)
    {
        $perPage = intval(request('perPage', 0));
        if ($perPage > 0) {
            return $query->paginate($perPage);
        }
        return $query->get();
    }
}
