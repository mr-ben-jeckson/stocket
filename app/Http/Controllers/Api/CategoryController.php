<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryListsResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function lists()
    {
        return CategoryListsResource::collection(Category::all());
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
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        if(Category::where('name', $data['name'])->exists()){
            return response()->json([
                'message' => 'Category already exists'
            ], 422);
        } else {
            if($data['nested'] == 0) {
                $data['type'] = 'main';
            } elseif ($data['nested'] == 1) {
                $data['type'] = 'sub';
            } elseif ($data['nested'] == 2) {
                $data['type'] = 'child';
            }
            if($data['parent_id'] == null) {
                $data['parent_id'] = 0;
            }
            $category = Category::create($data);
            return new CategoryResource($category);
        }
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
    public function update(CategoryRequest $request, Category $category)
    {
            $data = $request->validated();
            if(Category::where('name', $data['name'])->where('id', '!=', $category->id)->exists()){
                return response()->json([
                    'message' => 'Category already exists'
                ], 422);
            } else {
                if($data['nested'] == 0) {
                    $data['type'] = 'main';
                } elseif ($data['nested'] == 1) {
                    $data['type'] = 'sub';
                } elseif ($data['nested'] == 2) {
                    $data['type'] = 'child';
                }
                if($data['parent_id'] == null) {
                    $data['parent_id'] = 0;
                }
                $category->update($data);
                return new CategoryResource($category);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
