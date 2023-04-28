<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::query()->orderBy('created_at', 'desc')->paginate(12);
        return view('products.index', [
            'products' => $products
        ]);
    }
}
