<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::orderBy('name', 'asc')->get();
        return view('admin.item.index', compact('items')); 
    }

    public function create()
    {
        $categories = Category::orderBy('cat_name', 'asc')->get();
        return view('admin.item.create', compact('categories'));    
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'img_item'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'is_active'   => 'required|boolean',
        ], [
            'name.required'        => 'Item name is required',
            'price.required'       => 'Price is required',
            'category_id.required' => 'Category is required',
            'img_item.image'       => 'File must be an image',
            'img_item.mimes'       => 'Image must be a file of type: jpeg, png, jpg, gif, svg',
            'img_item.max'         => 'Image may not be greater than 2048 kilobytes',
        ]);

        $imageName = null; 
        if ($request->hasFile('img_item')) {
            $image = $request->file('img_item');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img_item_upload'), $imageName);
        }

        $item = new Item();
        $item->name = $request->name;
        $item->category_id = $request->category_id;
        $item->price = $request->price;
        $item->description = $request->description;
        $item->is_active = $request->is_active;
        $item->img = $imageName; 
        $item->save();

        return redirect()->route('admin.items.index')->with('success', 'Item created successfully!');
    }

    public function edit(string $id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::orderBy('cat_name', 'asc')->get();
        return view('admin.item.edit', compact('item', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'img_item'    => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'is_active'   => 'required|boolean',
        ], [
            'name.required'        => 'Item name is required',
            'price.required'       => 'Price is required',
            'category_id.required' => 'Category is required',
            'img_item.image'       => 'File must be an image',
            'img_item.mimes'       => 'Image must be a file of type: jpeg, png, jpg, gif, svg',
            'img_item.max'         => 'Image may not be greater than 2048 kilobytes',
        ]);

        $item = Item::findOrFail($id);
        $item->name = $request->name;
        $item->category_id = $request->category_id;
        $item->price = $request->price;
        $item->description = $request->description;
        $item->is_active = $request->is_active;

        if ($request->hasFile('img_item')) {
            if ($item->img && file_exists(public_path('img_item_upload/' . $item->img))) {
                unlink(public_path('img_item_upload/' . $item->img));
            }

            $image = $request->file('img_item');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img_item_upload'), $imageName);
            
            $item->img = $imageName;
        }

        $item->save();

        return redirect()->route('admin.items.index')->with('success', 'Item updated successfully!');
    }

    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.items.index')->with('success', 'Item deleted successfully!');
    }

}