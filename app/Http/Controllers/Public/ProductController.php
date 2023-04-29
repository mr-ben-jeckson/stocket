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
            return view('products.detail', [
                'product' => $product
            ]);
        }
    }
}
