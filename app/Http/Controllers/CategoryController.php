<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Function to get all categories where the associated brand is visible
    public function index()
    {
        $categories = Category::with('brand')->whereHas('brand', function($query) {
            $query->where('visible', true);
        })->where('visible', true)->get();

        return response()->json($categories);
    }

    // Function to get a single category by ID where the associated brand is visible
    public function show($id)
    {
        $category = Category::with('brand')->where('id', $id)
            ->whereHas('brand', function($query) {
                $query->where('visible', true);
            })->where('visible', true)->first();

        if ($category) {
            return response()->json($category);
        } else {
            return response()->json(['error' => 'Category not found or brand not visible'], 404);
        }
    }

    // Function to create a new category
    public function store(Request $request)
    {
        $request->validate([
            'ku' => 'required|string|max:255',
            'ar' => 'required|string|max:255',
            'en' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|string|max:255',
        ]);

        $category = Category::create($request->all());

        return response()->json($category, 201);
    }

    // Function to update a category
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if ($category) {
            $request->validate([
                'ku' => 'string|max:255',
                'ar' => 'string|max:255',
                'en' => 'string|max:255',
                'brand_id' => 'exists:brands,id',
                'image' => 'nullable|string|max:255',
            ]);
            
            $category->update($request->all());
            return response()->json($category);
        } else {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }

    // Function to delete a category
    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->visible=false;
            $category->save();
            return response()->json(['message' => 'Category deleted successfully']);
        } else {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }

    // Function to get categories by brand ID where the brand is visible
    public function getByBrandId($brand_id)
    {
        $categories = Category::where('brand_id', $brand_id)
            ->whereHas('brand', function($query) {
                $query->where('visible', true);
            })->where('visible', true)->get();

        if ($categories->isEmpty()) {
            return response()->json(['error' => 'No categories found for this brand or brand is not visible'], 404);
        }

        return response()->json($categories);
    }
}