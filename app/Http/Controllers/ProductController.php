<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->input('page', 1);
            $rows = $request->input('rows', 10);

            $query = Product::query();
            $total = $query->count();

            $products = $query->skip(($page - 1) * $rows)->take($rows)->get();

            return response()->json([
                'total' => $total,
                'rows'  => $products
            ]);
        }

        $products = Product::latest()->paginate(5);
        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Store a newly created product (POST).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'detail' => 'required|string',
        ]);

        $product = Product::create($validated);

        return $request->ajax()
            ? response()->json(['success' => true, 'message' => 'Product created', 'data' => $product])
            : redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product (GET /products/{id}).
     */
    public function show(Product $product)
    {
        return request()->ajax()
            ? response()->json($product)
            : view('products.show', compact('product'));
    }

    /**
     * Update the specified product (PUT/PATCH).
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'detail' => 'required|string',
        ]);

        $product->update($validated);

        return $request->ajax()
            ? response()->json(['success' => true, 'message' => 'Product updated'])
            : redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product (DELETE).
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return request()->ajax()
            ? response()->json(['success' => true, 'message' => 'Product deleted'])
            : redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
