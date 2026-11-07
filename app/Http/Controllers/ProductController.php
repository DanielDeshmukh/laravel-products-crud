<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index()
{
    $products = Product::all();
    return view('products.index', compact('products'));
}

public function create()
{
    return view('products.create');
}

public function store(Request $request)
{
    $data = $request->validate([
        'name'  => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ]);

    Product::create($data);
    return redirect()->route('products.index');
}

public function destroy(Product $product)
{
    $product->delete();
    return redirect()->route('products.index');
}

public function edit(Product $product)
{
    return view('products.edit', compact('product'));
}

public function update(Request $request, Product $product)
{
    $data = $request->validate([
        'name'  => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ]);

    $product->update($data);
    return redirect()->route('products.index');
}
       
    
}
