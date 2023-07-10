<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'size',
        'color',
        'image',
        'type',
        'stock',
        'plus',
        'extra_plus',
        'created_by'
    ];
}
