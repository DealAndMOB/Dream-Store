<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductManagementController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.gestion_productos.index', compact('products'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:5120', // Aumentado a 5MB
        ], [
            'name.required' => 'El nombre del producto es obligatorio',
            'description.required' => 'La descripción es obligatoria',
            'price.required' => 'El precio es obligatorio',
            'price.numeric' => 'El precio debe ser un número',
            'price.min' => 'El precio no puede ser negativo',
            'stock.required' => 'El stock es obligatorio',
            'stock.integer' => 'El stock debe ser un número entero',
            'stock.min' => 'El stock no puede ser negativo',
            'image.required' => 'La imagen es obligatoria',
            'image.image' => 'El archivo debe ser una imagen',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif, webp, svg o bmp',
            'image.max' => 'La imagen no debe pesar más de 5MB',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $imagePath;
        }

        $product = Product::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Producto creado exitosamente',
            'product' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado exitosamente',
            'product' => $product
        ]);
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente'
        ]);
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
            'operation' => 'required|in:add,subtract,set'
        ]);

        $currentStock = $product->stock;
        
        switch($request->operation) {
            case 'add':
                $product->stock = $currentStock + $request->stock;
                break;
            case 'subtract':
                $product->stock = max(0, $currentStock - $request->stock);
                break;
            case 'set':
                $product->stock = $request->stock;
                break;
        }

        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Stock actualizado exitosamente',
            'new_stock' => $product->stock
        ]);
    }

    public function toggleStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Estado del producto actualizado',
            'is_active' => $product->is_active
        ]);
    }

    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }
}