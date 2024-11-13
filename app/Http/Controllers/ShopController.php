<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        // Obtener solo productos activos y ordenados por más recientes
        $products = Product::where('is_active', true)
                          ->where('stock', '>', 0)
                          ->latest()
                          ->get();

        // Agrupar productos por estado de stock para estadísticas
        $stats = [
            'total_products' => $products->count(),
            'low_stock_products' => $products->where('stock', '<', 10)->count(),
            'total_value' => $products->sum(function($product) {
                return $product->price * $product->stock;
            })
        ];

        return view('welcome', compact('products', 'stats'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $sort = $request->get('sort', '');
        $stock = $request->get('stock', '');

        $productsQuery = Product::where('is_active', true);

        // Aplicar búsqueda si existe
        if ($query) {
            $productsQuery->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            });
        }

        // Aplicar filtro de stock
        switch ($stock) {
            case 'in_stock':
                $productsQuery->where('stock', '>', 0);
                break;
            case 'low_stock':
                $productsQuery->where('stock', '<', 10)->where('stock', '>', 0);
                break;
        }

        // Aplicar ordenamiento
        switch ($sort) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'name':
                $productsQuery->orderBy('name', 'asc');
                break;
            default:
                $productsQuery->latest();
                break;
        }

        $products = $productsQuery->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'products' => $products
            ]);
        }

        return view('welcome', compact('products'));
    }

    public function addToCart(Request $request, Product $product)
    {
        // Aquí implementarías la lógica del carrito
        // Por ahora solo devolvemos una respuesta de éxito
        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito'
        ]);
    }

    public function addToWishlist(Request $request, Product $product)
    {
        // Aquí implementarías la lógica de la lista de deseos
        // Por ahora solo devolvemos una respuesta de éxito
        return response()->json([
            'success' => true,
            'message' => 'Producto agregado a favoritos'
        ]);
    }
}