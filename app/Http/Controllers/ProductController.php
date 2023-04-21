<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductListsResource;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search', false);
        $perPage = request('per_page', 10);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        $query = Product::query();
        $query->orderBy($sortField, $sortDirection);
        if($search) {
            $query->where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%");
        }
        return ProductListsResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $url = [];
        $mine = [];
        $size = [];

        // File Saving to Storage
        if($request->hasFile('image')) {
            foreach($request->file('image') as /** @var \Illuminate\Http\UploadedFile $image */ $image) {
                       $relativePath = $this->saveImage($image);
                       array_push($url, URL::to(Storage::url($relativePath)));
                       array_push($mine, $image->getClientMimeType());
                       array_push($size, $image->getSize());
            }
        }

        // DB images json structure
        $data['images'] = json_encode([
            'url' => $url,
            'mime' => $mine,
            'size' => $size
         ]);

        //Product Model Saving
        $product = Product::create([
            'title' => $data['title'],
            'images' => $data['images'],
            'description' => $data['description'],
            'price' => $data['price'],
            'is_published' => $data['published'],
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        //Sync of Tags and Categories via Pivot Tables
        if(isset($data['category'])) $product->categories()->sync($data['category']);
        if(isset($data['tag'])) $product->tags()->sync($data['tag']);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,\App\Models\Product  $product)
    {
        // adding deleted by
        $product->update([
            'deleted_by'=> $request->user()->id
        ]);
        // remove categories from pivot
        $product->categories()->detach();
        // remove tags from pivot
        $product->tags()->detach();
        //soft delete
        $product->delete();

        return response()->noContent();
    }

    private function saveImage(\Illuminate\Http\UploadedFile $image) {
        $path = 'images/' . Str::random();
        if(!Storage::exists($path)) {
            Storage::makeDirectory($path, 0755, true);

        }
        if(!Storage::putFileAs('public/'.$path, $image, $image->getClientOriginalName())) {
            throw new \Exception("Unable to save \"{$image->getClientOriginalName()}\"");
        }

        return $path. '/' . $image->getClientOriginalName();
    }
}
