<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // Function to get all visible brands
    public function index()
    {
        $brands = Brand::where('visible', true)->get();
        return response()->json($brands);
    }

    // Function to get a single brand by ID
    public function show($id)
    {
        $brand = Brand::where('id', $id)->where('visible', true)->first();

        if ($brand) {
            return response()->json($brand);
        } else {
            return response()->json(['error' => 'Brand not found'], 404);
        }
    }

    // Function to store a new brand
    public function store(Request $request)
    {
        $request->validate([
            'ku' => 'required|string|max:255',
            'ar' => 'required|string|max:255',
            'en' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'visible' => 'required|boolean', // Validate visible attribute
        ]);

        $brand = Brand::create($request->all());

        return response()->json($brand, 201);
    }

    // Function to update an existing brand
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);

        if ($brand) {
            $brand->update($request->all());
            return response()->json($brand);
        } else {
            return response()->json(['error' => 'Brand not found'], 404);
        }
    }

    // Function to delete a brand
    public function destroy($id)
    {
        $brand = Brand::find($id);

        if ($brand) {
            $brand->delete();
            return response()->json(['message' => 'Brand deleted successfully']);
        } else {
            return response()->json(['error' => 'Brand not found'], 404);
        }
    }
}