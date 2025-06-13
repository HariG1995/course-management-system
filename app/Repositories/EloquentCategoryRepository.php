<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    public function all(): Collection
    {
        return Category::withCount('courses')->get();
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function find(int $id)
    {
        return Category::with('courses')->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $category = $this->find($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->find($id);
        return $category->delete();
    }
}