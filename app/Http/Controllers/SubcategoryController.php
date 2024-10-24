<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the subcategories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $subcategories = Subcategory::where('visible', true)->get();
        return response()->json($subcategories);
    }

    /**
     * Store a newly created subcategory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ku' => 'required|string|max:255',
            'ar' => 'required|string|max:255',
            'en' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|string|max:255',
        ]);

        $subcategory = Subcategory::create($validatedData);

        return response()->json($subcategory, 201); // 201 Created
    }

    /**
     * Display the specified subcategory.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        return response()->json($subcategory);
    }

    /**
     * Update the specified subcategory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $validatedData = $request->validate([
            'ku' => 'sometimes|required|string|max:255',
            'ar' => 'sometimes|required|string|max:255',
            'en' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image' => 'nullable|string|max:255',
        ]);

        $subcategory->update($validatedData);

        return response()->json($subcategory, 200); // 200 OK
    }

    /**
     * Remove the specified subcategory from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();

        return response()->json(null, 204); // 204 No Content
    }

    /**
     * Get subcategories based on category_id.
     *
     * @param  int  $category_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByCategoryId($category_id)
    {
        $subcategories = Subcategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }
}
