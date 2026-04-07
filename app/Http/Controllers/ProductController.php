<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        /** @var \App\Models\Commerce $commerce */
        $commerce = auth()->user()->commerces()->first();
        if (!$commerce) return redirect()->route('commerce.profile.edit');
        $products = $commerce->products()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $commerce = auth()->user()->commerces()->first();
        $request->validate([
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $commerce->products()->create($data);
        return redirect()->route('products.index')->with('status', 'Producto creado exitosamente.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            // Eliminar imagen antigua si existe
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('products.index')->with('status', 'Producto actualizado exitosamente.');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        return redirect()->route('products.index')->with('status', 'Producto eliminado.');
    }
}
