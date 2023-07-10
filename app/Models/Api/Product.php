<?php

namespace App\Models\Api;

use App\Models\Product as ModelsProduct;

class Product extends ModelsProduct
{
    public function getRouteKeyName() {
        return 'id';
    }
}
