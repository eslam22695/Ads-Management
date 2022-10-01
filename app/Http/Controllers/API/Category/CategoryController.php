<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;

use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends BaseController
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::latest()->get();
        return $this->sendResponse(CategoryResource::collection($data), 'Categories fetched.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
    
        }

        $Category = Category::create([
            'title' => $request->title
        ]);

        return $this->sendResponse(new CategoryResource($Category), 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Category = Category::find($id);
        if (is_null($Category)) {
            return $this->sendError('Data not found',[],404);
        }
        return $this->sendResponse(new CategoryResource($Category), 'Category fetched successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $Category)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $Category->title = $request->title;
        $Category->save();
        return $this->sendResponse(new CategoryResource($Category), 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $Category)
    {
        $Category->delete();

        return $this->sendResponse([], 'Category deleted successfully.');
    }
}
