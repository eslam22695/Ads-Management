<?php

namespace App\Http\Controllers\API\Ads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;

use App\Models\Ads;
use App\Http\Resources\AdsResource;

class AdsController extends BaseController
{
    //Get all Advertiser Ads
    public function ads(Request $request, $advertiser_id = null)
    {
        $input = $request->all();

        $ads = Ads::query();

        if($advertiser_id)
        {
            $ads->where('advertiser_id',$advertiser_id);
        }

        if($request->has('category_id'))
        {
            $ads->where('category_id',$input['category_id']);
        }

        if($request->has('tag_id'))
        {
            $ads->whereHas('tags', function($q) use($input){
                $q->where('tags.id',$input['tag_id']);
            });
        }

        $ads = $ads->with('category','advertiser','tags')->get();

        return $this->sendResponse(AdsResource::collection($ads), 'Advertiser Ads fetched.');
    }
}
