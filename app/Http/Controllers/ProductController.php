<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Product::query();

        // Apply category filter
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        // Apply price range filter
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Paginate products
        $products = $query
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->select('products.*', 'product_images.image_path as image')
            ->paginate(4);

        // Fetch all categories for the filter dropdown
        $categories = Category::all();

        return view('welcome', compact('products', 'categories'));
    }


    public function adminProduct()
    {
        $products = Product::with('category')->where('isDeleted', false)->get();
    return view('product.admin_product', compact('products'));
    }

    public function create()
    {

        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'type' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $product = Product::create($validated);
        Category::find($validated['category_id'])->increment('quantity', $validated['quantity']);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Generate a custom file name
                $fileName = $validated['name'] . '/image' . ($index + 10) . '.' . $image->getClientOriginalExtension();

                // Define the full path for the file
                $filePath = 'products/' . $fileName;

                // Store the file in the 'public' disk with the custom path
                $image->storeAs('products', $fileName, 'public');

                // Save the file path to the database
                $product->images()->create(['image_path' => $filePath]);
            }
        }


        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function show(Product $product)
    {
        $product = Product::with('images', 'category')->findOrFail($product->id);
        return view('product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'type' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $product->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Generate a custom file name
                $fileName = $validated['name'] . '/image' . ($index + 1) . '.' . $image->getClientOriginalExtension();

                // Define the full path for the file
                $filePath = 'products/' . $fileName;

                // Store the file in the 'public' disk with the custom path
                $image->storeAs('products', $fileName, 'public');

                // Save the file path to the database
                $product->images()->create(['image_path' => $filePath]);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {

        $product->update(['isDeleted' => true]);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }



    public function deleteImage($imageId)
    {
        // Find the image in the database (assuming you have a ProductImage model)
        $image = DB::table('product_images')->where('id', $imageId)->first();
        if ($image) {
            // Get the full path to the image
            $imagePath = storage_path('app/public/' . $image->image_path); // Adjust the path as needed

            // Delete the image file from the server
            if (file_exists($imagePath)) {
                unlink($imagePath); // Deletes the file
            }

            DB::table('product_images')->where('id', $imageId)->delete();
            return redirect()->back()->with('success', 'Image deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Image not found.');
    }
}

public function showDigitalProducts()
{
    // Assuming you have a Product model with a relationship to Category
    $products = Product::with('category')->where('type', 'Digital')->get();
    
    return view('product.digital', compact('products'));
}

public function showPhysicalProducts()
{
    // Assuming you have a Product model with a relationship to Category
    $products = Product::with('category')->where('type', 'Physical')->get();
    
    return view('product.physical', compact('products'));
}

}
