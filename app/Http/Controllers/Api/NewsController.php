<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Newsupdate;

class NewsController extends Controller
{
     public function getnews()
    {
        $news =Newsupdate::where('status','Active')->get();
        $response = [
            'status' => true,
            'message'=>'List of active news & updates',
            "data"=> [
                'news'=> $news,
            ]

        ];
        return response()->json($response,200);
    }

    public function getnewsbyid($slug)
    {
        $news =Newsupdate::where('slug',$slug)->where('status','Active')->first();
        $response = [
            'status' => true,
            'message'=>'News & updates by id',
            "data"=> [
                'news'=> $news,
            ]

        ];
        return response()->json($response,200);
    }
}
