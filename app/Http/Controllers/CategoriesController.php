<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index() {
        $categories = Category::withCount('posts')->orderBy('posts_count', 'desc')->get();
        return $categories;
    }
    public function store() {
        Category::create($this->validateData());
    }

    public function update(Category $category) {
        $category->update($this->validateData());
    }

    public function delete(Category $category) {
        $category->delete();
    }

    /**
     * @return mixed
     */
    public function validateData()
    {
        $data = request()->validate([
            'name' => 'required'
        ]);
        return $data;
    }
}
