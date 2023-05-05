<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class InventoryContorller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InventoryRequest $request)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;
        if ($image) {
            $data['image'] = $this->saveImage($image);
        }
        $data['color'] = json_encode($data['color']);
        $data['created_by'] = $request->user()->id;
        // String Value of SQL Column Row Type which does exist
        $data['type'] = $this->typeDefinder($data);
        $inventory = Inventory::create($data);
        return new InventoryResource($inventory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function typeDefinder($data)
    {
        $dataType = null;
        if($data['size']) {
            $dataType = 'SIZE';
        }
        if($data['color']) {
            if($dataType) $dataType = $dataType.'+ COLOR';
            else  $dataType = 'COLOR';
        }
        if($data['image']) {
            if($dataType) $dataType = $dataType.'+ IMAGE';
            else  $dataType = 'IMAGE';
        }
        if($data['plus']) {
            if($dataType) $dataType = $dataType.'+ ADD-PRICE';
            else  $dataType = 'ADD_PRICE';
        }
        return $dataType;
    }

    private function saveImage(\Illuminate\Http\UploadedFile $image)
    {
        $path = 'images/stock/' . uniqid();
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0755, true);
        }
        if (!Storage::putFileAs('public/' . $path, $image, $image->getClientOriginalName())) {
            throw new \Exception("Unable to save \"{$image->getClientOriginalName()}\"");
        }
        return URL::to(Storage::url($path . '/' . $image->getClientOriginalName()));
    }
}
