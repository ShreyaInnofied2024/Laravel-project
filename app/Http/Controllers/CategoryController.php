<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $slug = $request->input('slug') ?? str()->slug($validated['name']);

    Category::create([
        'name' => $validated['name'],
        'slug' => $slug,
    ]);

        return redirect()->route('category.index')->with('success', 'category added successfully!');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('products');
        return view('category.show', compact('category'));
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        
        $category->delete();
    
        return redirect()->route('category.index')
            ->with('success', 'Category deleted successfully.');   //
    }
}
