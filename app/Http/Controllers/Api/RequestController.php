<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MovieMedia;
use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    public function request() {
        $request = Request::first();
        return response()->json($request);
    }

    public function del_request(HttpRequest $request) {
        Request::where('id', $request['id'])->delete();
        $media = MovieMedia::where('id', intval($request['index_movie']))->first();
        $media->movie_media = $request['media'];
        $media->save();
        return $request;
    }
}