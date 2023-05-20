<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Newsupdate;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Seennewsupdate;

class NewsController extends Controller
{
     public function getnews()
    {
        $uss =Newsupdate::where('status','Active')->get();

        if(count($uss)>0){
            foreach($uss as $us){
                $use=$us;
                $use->postImage=env('PROD_URL').$use->postImage;
                $se=Seennewsupdate::where('news_id',$use->id)->first();
                if(isset($se)){
                    $use->seen=$se->seen;
                }else{
                    $use->seen=false;
                }
                $news[]=$use;
            }
        }else{
            $news=[];
        }

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
        $news->postImage=env('PROD_URL').$news->postImage;
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