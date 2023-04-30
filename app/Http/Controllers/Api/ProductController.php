<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductListsResource;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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
        if ($search) {
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
        $objectArray = array();
        // File Saving to Storage
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as
            /** @var \Illuminate\Http\UploadedFile $image */
            $image) {
                // saving image
                $relativePath = $this->saveImage($image);
                // object map needs four arguments
                $object = $this->imageObjectMap(URL::to(Storage::url($relativePath)), $image->getClientMimeType(), $relativePath, $image->getSize());
                array_push($objectArray, $object);
            }
        }

        // DB images json structure
        $data['images'] = json_encode($objectArray);

        //Product Model Saving
        $product = Product::create([
            'title' => $data['title'],
            'images' => $data['images'],
            'features' => json_encode($data['features']),
            'description' => $data['description'],
            'price' => $data['price'],
            'is_published' => $data['published'],
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        //Sync of Tags and Categories via Pivot Tables
        if (isset($data['category'])) $product->categories()->sync($data['category']);
        if (isset($data['tag'])) $product->tags()->sync($data['tag']);

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
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        $data['is_published'] = $data['published'];
        $imagesArray = json_decode($product->images) ?? array();
        // File Saving to Storage
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as
            /** @var \Illuminate\Http\UploadedFile $image */
            $image) {
                // saving image
                $relativePath = $this->saveImage($image);
                // object map needs four arguments
                $object = $this->imageObjectMap(URL::to(Storage::url($relativePath)), $image->getClientMimeType(), $relativePath, $image->getSize());
                array_push($imagesArray, $object);
            }
            $reindexImagesObjectArray = array_values($imagesArray);
            $data['images'] = json_encode($reindexImagesObjectArray);
        }

        //Sync of Tags and Categories via Pivot Tables
        if (isset($data['category'])) $product->categories()->sync($data['category']);
        if (isset($data['tag'])) $product->tags()->sync($data['tag']);
        $data['features'] = json_encode($data['features']);
        $product->update($data);

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        // adding deleted by
        $product->update([
            'deleted_by' => $request->user()->id
        ]);
        // remove categories from pivot
        $product->categories()->detach();
        // remove tags from pivot
        $product->tags()->detach();
        //soft delete
        $product->delete();

        return response()->noContent();
    }

    public function singleImageRemove(Request $request)
    {

        $id = request('id', null);
        $index = request('index', null);
        $url = request('url', null);
        //extract product
        $product = Product::find($id);

        //decode Json object to collection
        $imagesObjectArray = json_decode($product->images);

        //dynamic variables to extract the index
        foreach ($imagesObjectArray as $key => $imageObject) {
            //avoid duplicated id (becasuse it is not unqine column of database table)
            if ($imageObject->id === $index && $imageObject->url === $url) {
                //take an object from array
                $itemImage = $imageObject;
                //take an array key
                $removeIndex = $key;
            }
        }

        //check variable
        if (isset($itemImage)) {
            // array unset like laravel avaliable method
            $updateImagesObjectArray = arr::except($imagesObjectArray, [$removeIndex]);

            // ****** Important to reindex the array
            $reindexImagesObjectArray = array_values($updateImagesObjectArray);

            //delete from storage
            if (Storage::exists('public/' . $itemImage->storage)) {
                Storage::deleteDirectory('public/' . dirname($itemImage->storage));;
            } else {
                //avoid faker data
                if ($itemImage->storage == "faker/fake.png" || $itemImage->storage == "faker/fake.jpg") {
                } else {
                    throw new \Exception("Unable to delete \"{$itemImage->storage} file not removed\"");
                }
            }

            //encode Json object
            $updateObjectArray = json_encode($reindexImagesObjectArray);

            //updating product
            $product->update([
                'images' => $updateObjectArray,
                'updated_by' => $request->user()->id
            ]);

            $response = json_decode($updateObjectArray);
            return response($response, 201);
        } else {
            return response(json_decode($product->image), 200);
        }
    }

    private function folderNameFormat()
    {
        $unqiue = uniqid();
        $timestamp = now()->getTimestampMs();
        $date = str_replace([' ', ':', '+'], '', now()->toString());
        return $unqiue . '-' . $timestamp . $date;
    }

    private function saveImage(\Illuminate\Http\UploadedFile $image)
    {
        $path = 'images/' . $this->folderNameFormat();
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0755, true);
        }
        if (!Storage::putFileAs('public/' . $path, $image, $image->getClientOriginalName())) {
            throw new \Exception("Unable to save \"{$image->getClientOriginalName()}\"");
        }

        return $path . '/' . $image->getClientOriginalName();
    }

    private function imageObjectMap($url, $mine, $storage, $size)
    {
        $dataObject = (object) [
            'id' => uniqid(),
            'url' => $url,
            'mine' => $mine,
            'storage' => $storage,
            'size' => $size,
            'created_at' => now(),
        ];
        return $dataObject;
    }
}
