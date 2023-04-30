<?php

namespace App\Http\Controllers\Public;

use App\Helpers\Cart;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        list($products, $cartItems) = Cart::getProductsAndCartItems();
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $cartItems[$product->id]['quantity'];
        }

        return view('cart.index', compact('cartItems', 'products', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = $request->post('quantity', 1);
        $user = $request->user();

        if ($user) {
            $cartItems = CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->first();
            if ($cartItems) {
                $cartItems->quantity += $quantity;
                $cartItems->update();
            } else {
                $data = [
                    'user_id' => $request->user()->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity
                ];
                CartItem::create($data);
            }

            return response([
                'count' => Cart::getCartItemsCount()
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            $isProductExist = false;
            foreach($cartItems as &$item) {
                if($item['product_id'] === $product->id) {
                    $item['quantity'] += $quantity;
                    $isProductExist = true;
                    break;
                }
            }
            if(!$isProductExist) {
                $cartItems[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ];
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }

    public function remove(Request $request, Product $product)
    {
        $user = $request->user();
        if($user) {
            $cartItems = CartItem::where(['user_id'=> $user->id, 'product_id' => $product->id])->first();
            if($cartItems) {
                $cartItems->delete();
            }
            return response(['count'=> Cart::getCartItemsCount()]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach($cartItems as $key=>&$item) {
                if($item['product_id'] === $product->id) {
                    array_splice( $cartItems, $key, 1);
                    break;
                }
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }

    }

    public function updateQuantity(Request $request, Product $product)
    {
        $quantity = (int)$request->post('quantity');
        $user = $request->user();
        if($user) {
            CartItem::where(['user_id'=> $user->id, 'product_id' => $product->id])->update(['quantity' => $quantity]);
            return response(['count' => Cart::getCartItemsCount()]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach ($cartItems as &$item) {
                if($item['product_id'] === $product->id) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }
}
