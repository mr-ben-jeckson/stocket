<?php

namespace App\Helpers;

use App\Http\Resources\ColorResource;
use App\Models\Inventory;

class SizeColor
{
    public static function getColorsStock($productId, $size) {
        $colorStocks = Inventory::where(['product_id'=> $productId, 'size' => $size])->get();
        return ColorResource::collection($colorStocks);
    }

    public static function getDefaultColorFromSize($productId, $size) {
        $colorStocks = Inventory::where(['product_id'=> $productId, 'size' => $size])->get();
        $color = $colorStocks[0];
        return new ColorResource($color);
    }
}
