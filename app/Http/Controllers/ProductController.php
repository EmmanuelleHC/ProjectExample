<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

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

  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $product = Product::create($request->all());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Product created successfully', 'data' => $product]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        if (request()->ajax()) {
            return response()->json($product);
        }

        return view('products.show', compact('product'));
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $product->update($request->all());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Product updated successfully']);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

  
    public function destroy(Request $request, Product $product)
    {
        $product->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
