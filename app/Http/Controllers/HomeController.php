<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getHomePage()
    {
        $home_movies = Movie::select('movies.*')->distinct()->join('movie_media', 'movies.id_movie', '=', 'movie_media.movie_id')->take(12)->get();
        $index = 12;
        return view('pages.home', compact('home_movies', 'index'));
    }

    public function getHomeAjax(Request $request)
    {
        $home_movies = Movie::select('movies.*')->distinct()->join('movie_media', 'movies.id_movie', '=', 'movie_media.movie_id')->where('id_movie', '>', $request->index)->take(12)->get();
        $output = '';
        foreach ($home_movies as $movie) {
            $output .= '<a href="' . route('detail_name', $movie->slug) . '" class="card__film">';

            if ($movie->image == '' || $movie->image == null) {
                $url_image = asset('img/' . $movie->category . $movie->id . '.jpg');
            } else {
                $url_image = $movie->image;
            }
            $output .= '
                <img class="image" src="' . $url_image . '" alt="image" />
                <p class="film__name">' . $movie->name . '</p>
            </a>';
        }
        $data = ['movies' => $output, 'index' => $request->index + 12];
        return response()->json($data);
    }
}
