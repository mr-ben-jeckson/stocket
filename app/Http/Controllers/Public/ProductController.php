<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->where('is_published', '=', 1)->orderBy('created_at', 'desc')->paginate(12);
        return view('products.index', [
            'products' => $products
        ]);
    }

    public function show(Product $product)
    {
        if ($product->is_published == 0) {
            return back();
        } else {
            $getSize = $product->stocks->unique('size');
            $sizes = $getSize->map(
               fn($getSize)=>[
                    'id' => $getSize->id,
                    'size' => $getSize->size,
                    'plus' => $getSize->plus,
                    'extraPlus' => $getSize->extra_plus
               ]
            );
            $getColor = $product->stocks;
            $colors = $getColor->map(
                fn($getColor) => [
                    'id' => $getColor->id,
                    'size' => $getColor->size,
                    'color' => json_decode($getColor->color, false),
                    'plus' => $getColor->plus,
                    'extraPlus' => $getColor->extra_plus
                ]
            );
            return view('products.detail', [
                'product' => $product,
                'sizes' => $sizes,
                'colors' => $colors
            ]);
        }
    }
}
