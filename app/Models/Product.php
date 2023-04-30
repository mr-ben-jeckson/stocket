<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'features',
        'price',
        'images',
        'created_by',
        'updated_by',
        'is_published',
        'deleted_by'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }

    public function getRouteKeyName() {
        return 'slug';
    }
}
