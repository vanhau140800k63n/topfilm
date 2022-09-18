<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getHomePage()
    {
        $home_movies = Movie::select('movies.*')->distinct()->join('movie_media', 'movies.id_movie', '=', 'movie_media.movie_id')->take(12)->get();
        return view('pages.home', compact('home_movies'));
    }
}
