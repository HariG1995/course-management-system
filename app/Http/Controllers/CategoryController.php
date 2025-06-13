<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->all();
        return view('pages.view_categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name'
        ]);

        $category = $this->categoryRepository->create($validated);

        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }

    public function edit($id)
    {
        $category = $this->categoryRepository->find($id);

        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name,'.$id
        ]);

        $category = $this->categoryRepository->update($id, $validated);

        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }

    public function destroy($id)
    {
        $row = $this->categoryRepository->delete($id);

        return response()->json([
            'status' => true,
            'data' => $row
        ]);
    }
}
