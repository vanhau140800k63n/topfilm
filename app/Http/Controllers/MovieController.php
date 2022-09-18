<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieMedia;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function getMovieByName($name)
    {
        $movie_detail = Movie::where('slug', $name)->first();

        $episode = 1;

        $sub = null;
        $movie_media = MovieMedia::where('movie_id', $movie_detail->id_movie)->where('episode', 1)->first();

        if(isset($movie_media->sub_vi) && !empty($movie_media->sub_vi)) {
            $sub = $movie_media->sub_vi;
        }

        $new_request = [
            'id_movie' => $movie_detail->id,
            'category' => $movie_detail->category,
            'episode' => 0,
            'index_movie' =>  $movie_media->id
        ];
        ModelsRequest::create($new_request);

        return view('pages.movie', compact('movie_detail', 'sub', 'movie_media', 'episode'));
    }

    public function getMovieByNameEposode($name, $episode)
    {
        $movie_detail = Movie::where('slug', $name)->first();

        $sub = null;
        $movie_media = MovieMedia::where('movie_id', $movie_detail->id_movie)->where('episode', $episode)->first();

        if(isset($movie_media->sub_vi) && !empty($movie_media->sub_vi)) {
            $sub = $movie_media->sub_vi;
        }

        $new_request = [
            'id_movie' => $movie_detail->id,
            'category' => $movie_detail->category,
            'episode' => $episode - 1,
            'index_movie' =>  $movie_media->id
        ];
        ModelsRequest::create($new_request);

        return view('pages.movie', compact('movie_detail', 'sub', 'movie_media', 'episode'));
    }

    public function getEpisodeAjax(Request $request) {
        $media = MovieMedia::where('movie_id', $request->movie_id)->where('episode', $request->episode)->first()->movie_media;
        return response()->json($media, 200);
    }
}
