<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the items.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items = Item::where('visible',true)->get();
        return response()->json($items);
    }

    /**
     * Store a newly created item in storage.
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
            'desc_ku' => 'nullable|string',
            'desc_ar' => 'nullable|string',
            'desc_en' => 'nullable|string',
            'subcategory_id' => 'required|exists:subcategories,id',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'visible' => 'required|boolean'
        ]);

        $item = Item::create($validatedData);
        return response()->json($item, 201); // 201 for created
    }

    /**
     * Display the specified item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return response()->json($item);
    }

    /**
     * Update the specified item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validatedData = $request->validate([
            'ku' => 'required|string|max:255',
            'ar' => 'required|string|max:255',
            'en' => 'required|string|max:255',
            'desc_ku' => 'nullable|string',
            'desc_ar' => 'nullable|string',
            'desc_en' => 'nullable|string',
            'subcategory_id' => 'required|exists:subcategories,id',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'visible' => 'required|boolean'
        ]);

        $item->update($validatedData);
        return response()->json($item);
    }

    /**
     * Remove the specified item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return response()->json(null, 204); // 204 for no content
    }

    /**
 * Get items by subcategory ID.
 *
 * @param  int  $subcategory_id
 * @return \Illuminate\Http\JsonResponse
 */
public function getItemsBySubcategory($subcategory_id)
{
    // Fetch items where subcategory_id matches the provided one
    $items = Item::where('subcategory_id', $subcategory_id)->get();

    if ($items->isEmpty()) {
        return response()->json(['message' => 'No items found for this subcategory'], 404);
    }

    return response()->json($items);
}

/**
 * Search items by name.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function searchByName(Request $request)
{
    $query = $request->input('name');

    if (empty($query)) {
        return response()->json(['message' => 'No search query provided'], 400);
    }

    $items = Item::where('visible', true)
                  ->where(function($q) use ($query) {
                      $q->where('ku', 'LIKE', "%{$query}%")
                        ->orWhere('ar', 'LIKE', "%{$query}%")
                        ->orWhere('en', 'LIKE', "%{$query}%");
                  })
                  ->get();

    return response()->json($items);
}

}
