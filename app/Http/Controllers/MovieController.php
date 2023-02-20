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

        if($movie_detail == null) {
            return view('errors.404');
        }
        $episode = 1;

        $sub = null;
        $movie_media = MovieMedia::where('movie_id', $movie_detail->id_movie)->where('episode', 1)->first();

        if(isset($movie_media->sub_vi) && !empty($movie_media->sub_vi)) {
            $sub = $movie_media->sub_vi;
        }

        return view('pages.movie', compact('movie_detail', 'sub', 'movie_media', 'episode'));
    }

    public function getMovieByNameEposode($name, $episode)
    {
        $movie_detail = Movie::where('slug', $name)->first();
        if($movie_detail == null) {
            return view('errors.404');
        }

        $sub = null;
        $movie_media = MovieMedia::where('movie_id', $movie_detail->id_movie)->where('episode', $episode)->first();

        if(isset($movie_media->sub_vi) && !empty($movie_media->sub_vi)) {
            $sub = $movie_media->sub_vi;
        }

        return view('pages.movie', compact('movie_detail', 'sub', 'movie_media', 'episode'));
    }

    public function getEpisodeAjax(Request $request) {
        $media = MovieMedia::where('movie_id', $request->movie_id)->where('episode', $request->episode)->first()->movie_media;
        return response()->json($media, 200);
    }
}
