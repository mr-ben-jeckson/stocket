<?php

namespace App\Http\Controllers\Public;

use App\Helpers\SizeColor;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
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
            $sizeColorStock = $product->stocks->whereNotIn('type', 'DEFAULT')
                                ->whereNotNull('size')
                                ->whereNotNull('color')
                                ->groupBy('size');
            $sizeOnlyStock = $product->stocks->whereNotIn('type', 'DEFAULT')
                                ->whereNotNull('size')
                                ->whereNull('color');
            $colorOnlyStock = $product->stocks->whereNotIn('type', 'DEFAULT')
                                ->whereNull('size')
                                ->whereNotNull('color');
            return view('products.detail', [
                'product' => $product,
                'sizeColorStock' => $sizeColorStock,
                'sizeOnlyStock' => $sizeOnlyStock,
                'colorOnlyStock' => $colorOnlyStock
            ]);
        }
    }
}
