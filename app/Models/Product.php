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
        return $this->belongsToMany(Category::class, 'product_category', 'category_id', 'product_id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'product_tag', 'tag_id', 'product_id');
    }
}
