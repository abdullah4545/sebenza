<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use App\Models\Newsupdate;
use Illuminate\Http\Request;

class NewsupdateController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Newsupdate  $newsupdate
     * @return \Illuminate\Http\Response
     */
    public function show(Newsupdate $newsupdate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Newsupdate  $newsupdate
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsupdate $newsupdate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Newsupdate  $newsupdate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newsupdate $newsupdate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Newsupdate  $newsupdate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsupdate $newsupdate)
    {
        //
    }
}
