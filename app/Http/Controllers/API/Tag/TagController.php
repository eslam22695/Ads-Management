<?php

namespace App\Http\Controllers\API\Tag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;

use App\Models\Tag;
use App\Http\Resources\TagResource;

class TagController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tag::latest()->get();
        return $this->sendResponse(TagResource::collection($data), 'Tags fetched.');
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

        $Tag = Tag::create([
            'title' => $request->title
        ]);

        return $this->sendResponse(new TagResource($Tag), 'Tag created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Tag = Tag::find($id);
        if (is_null($Tag)) {
            return $this->sendError('Data not found',[],404);
        }
        return $this->sendResponse(new TagResource($Tag), 'Tag fetched successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $Tag)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $Tag->title = $request->title;
        $Tag->save();
        return $this->sendResponse(new TagResource($Tag), 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $Tag)
    {
        $Tag->delete();

        return $this->sendResponse([], 'Tag deleted successfully.');
    }
}
