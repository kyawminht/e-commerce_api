<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    public function index()
    {
        $products=Product::paginate(10);
        if ($products){
            return response()->json([
                'products'=>$products,
                'status'=>200,
            ]);
        } else return response()->json('There are no products');
    }

    public function show($product) 
    {
        $product=Product::find($product);
        if (!$product){
            return response()->json([
                'message'=>"Product no found",
                'status'=>404,
            ]);
        }
         return response()->json([
            'products'=>$product,
            'status'=>200,
        ]);
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:products,name',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'required|exists:brands,id',
        'is_trendy' => 'boolean',
        'is_available' => 'boolean',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'discount' => 'required|numeric|min:0|max:100',
        'image' => 'required|image',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => $validator->errors(),
        ]);
    }

    $product = new Product();
    $product->name = $request->name;
    $product->category_id = $request->category_id;
    $product->brand_id = $request->brand_id;
    $product->is_trendy = $request->input('is_trendy', false);
    $product->is_available = $request->input('is_available', true);
    $product->price = $request->price;
    $product->quantity = $request->quantity;
    $product->discount = $request->discount;

    // Image upload
    $imagePath = 'uploads/products';
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $filename = time() . '.' . $ext;
        $file->move($imagePath, $filename);

        $product->image = $filename;
    }

    $product->save();

    return response()->json([
        'message' => 'Product added successfully.',
        'product' => $product,
    ]);
}

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:products,name,' . $id,
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'required|exists:brands,id',
        'is_trendy' => 'boolean',
        'is_available' => 'boolean',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'discount' => 'numeric',
        'image' => 'image',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => $validator->errors(),
        ]);
    }

    $product->name = $request->name;
    $product->category_id = $request->category_id;
    $product->brand_id = $request->brand_id;
    $product->is_trendy = $request->input('is_trendy', false);
    $product->is_available = $request->input('is_available', true);
    $product->price = $request->price;
    $product->quantity = $request->quantity;
    $product->discount = $request->discount;

    // Image update
    if ($request->hasFile('image')) {
        // Delete existing image
        if ($product->image) {
            Storage::delete('uploads/products/' . $product->image);
        }

        // Upload new image
        $imagePath = 'uploads/products';
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $filename = time() . '.' . $ext;
        $file->move($imagePath, $filename);

        $product->image = $filename;
    }

    $product->save();

    return response()->json([
        'message' => 'Product updated successfully.',
        'product' => $product,
    ]);
}

public function destroy($id)
{
    $product = Product::findOrFail($id);

    // Delete the product image
    if ($product->image) {
        Storage::delete('uploads/products/' . $product->image);
    }

    $product->delete();

    return response()->json([
        'message' => 'Product deleted successfully.',
    ]);
}
}