<?php

/**
 * User: Ben Jeckson
 * Date: 4/29/2023
 * Time: 11:29 AM
 */

namespace App\Helpers;

use App\Models\CartItem;

/**
 * Class Cart
 *
 * @author  Ben Jeckson <thanhtikexaw@gmail.com>
 * @package App\Helpers
 */
class Cart
{
    public static function getCartItemsCount(): int
    {
        $request = \request();
        $user = $request->user();
        if ($user) {
            return CartItem::where('user_id', $user->id)->sum('quantity');
        } else {
            $cartItems = self::getCookiesCartItems();

            return array_reduce(
                $cartItems,
                fn($carry, $item) => $carry + $item['quantity'], 0
            );
        }
    }

    public static function getCartItems()
    {
        $request = \request();
        $user = $request->user();
        if($user) {
            return CartItem::where('user_id', $user->id)->get()->map(
                fn($item) => ['product_id'=>$item->prdouct_id, 'quantity'=> $item->quantity]
            );
        } else {
            return self::getCookiesCartItems();
        }
    }

    public static function getCookiesCartItems()
    {
        $request = \request();
        return json_decode($request->cookie('cart_items', '[]'), true);
    }

    public static function getCountFromItems($cartItems)
    {
        return array_reduce(
            $cartItems,
            fn($carry, $item) => $carry + $item['quantity'], 0
        );
    }

    public static function moveCartItemToDb()
    {
        $request = \request();
        $cartItems = self::getCookiesCartItems();
        $dbCartIems = CartItem::where(['user_id' => $request->user()->id])->get()->keyBy('product_id');
        $newCartItems = [];
        foreach($cartItems as $cartItem) {
            if(isset($dbCartIems[$cartItem['product_id']])){
                continue;
            }
            $newCartItems[] = [
                'user_id' => $request->user()->id,
                'product_id' => $cartItem['product_id'],
                'quantity' => $cartItem['quantity']
            ];

        }

        if(!empty($newCartItems)) {
            CartItem::insert($newCartItems);
        }
    }
}
