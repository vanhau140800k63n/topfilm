<?php

namespace App\Http\Controllers;

use App\Constants\AdvancedSearch;
use App\Models\Movie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getHomeUrl()
    {
        return redirect('https://topfilm.devsne.vn/home');
    }

    public function getHomePage()
    {
        $home_movies = Movie::select('movies.*')->distinct()->join('movie_media', 'movies.id_movie', '=', 'movie_media.movie_id')->take(12)->get();
        $index = 12;
        return view('pages.home', compact('home_movies', 'index'));
    }

    public function removeMovie() {
        $myfile = fopen("remove.txt", "w+") or die("Unable to open file!");
        $index = intval(fgets($myfile));
        $movies = Movie::where('id_movie', '>', $index)->take(2000)->get();

        foreach($movies as $movie) {
            if(!file_exists(substr($movie->image, 26))) {
                $movie->delete();
            }
        }
        fwrite($myfile, $movie->id_movie);
        return 1;
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
                <p class="film__name">' . $movie->name . ' (' . $movie->year . ')</p>
            </a>';
        }

        $data = ['movies' => $output, 'index' => $request->index + $home_movies->count()];
        return response()->json($data);
    }

    public function searchMovieAdvanced($value)
    {
        $posA = strpos($value, 'a');
        $posB = strpos($value, 'b');
        $posC = strpos($value, 'c');
        $posD = strpos($value, 'd');

        $valueA = substr($value, $posA + 1, $posB - $posA - 1);
        $valueB = substr($value, $posB + 1, $posC - $posB - 1);
        $valueC = substr($value, $posC + 1, $posD - $posC - 1);
        $valueD = substr($value, $posD + 1);

        $search_advance_list = AdvancedSearch::SEARCH_LIST;

        $a = $search_advance_list[$valueA]['params'];

        // $c = $search_advance_list[$valueA]['screeningItems'][1]['items'][$valueC]['params'];
        // $d = $search_advance_list[$valueA]['screeningItems'][2]['items'][$valueD]['params'];

        $query = 'INSTR("' . $a . '", movies.drame_type) > 0';

        if (!empty($valueB)) {
            $b = explode(',', $search_advance_list[$valueA]['screeningItems'][0]['items'][$valueB]['params']);
            $sub_query = [];
            foreach ($b as $key => $item) {
                $sub_query[$key] = ' INSTR(movies.area_list, "' . $item . '") > 0 ';
            }
            $sub_query = implode('OR', $sub_query);
            $query .= ' AND (' . $sub_query . ' )';
        }

        if (!empty($valueC)) {
            $c = explode(',', $search_advance_list[$valueA]['screeningItems'][1]['items'][$valueC]['params']);
            $sub_query = [];
            foreach ($c as $key => $item) {
                $sub_query[$key] = ' INSTR(movies.tag_list, "' . $item . '") > 0 ';
            }
            $sub_query = implode('OR', $sub_query);
            $query .= ' AND (' . $sub_query . ' )';
        }

        if (!empty($valueD)) {
            $d = explode(',', $search_advance_list[$valueA]['screeningItems'][2]['items'][$valueD]['params']);

            if ($d[0] === $d[1]) {
                $sub_query = 'movies.year = ' . $d[0];
            } else {
                $sub_query = 'movies.year BETWEEN ' . $d[0] . ' AND ' . $d[1];
            }
            $query .= ' AND (' . $sub_query . ' )';
        }

        $home_movies = Movie::selectRaw('movies.*')->distinct()->join('movie_media', 'movies.id_movie', '=', 'movie_media.movie_id')
            ->whereRaw($query)->take(12)->get();

        $index = $home_movies[count($home_movies) - 1]->id_movie;

        return view('pages.search_advance', compact('value', 'valueA', 'valueB', 'valueC', 'valueD', 'home_movies', 'index'));
    }

    public function searchMovieAdvancedMore(Request $request)
    {
        $value = $request->value;

        $posA = strpos($value, 'a');
        $posB = strpos($value, 'b');
        $posC = strpos($value, 'c');
        $posD = strpos($value, 'd');

        $valueA = substr($value, $posA + 1, $posB - $posA - 1);
        $valueB = substr($value, $posB + 1, $posC - $posB - 1);
        $valueC = substr($value, $posC + 1, $posD - $posC - 1);
        $valueD = substr($value, $posD + 1);

        $search_advance_list = AdvancedSearch::SEARCH_LIST;

        $a = $search_advance_list[$valueA]['params'];

        // $c = $search_advance_list[$valueA]['screeningItems'][1]['items'][$valueC]['params'];
        // $d = $search_advance_list[$valueA]['screeningItems'][2]['items'][$valueD]['params'];

        $query = 'INSTR("' . $a . '", movies.drame_type) > 0';

        if (!empty($valueB)) {
            $b = explode(',', $search_advance_list[$valueA]['screeningItems'][0]['items'][$valueB]['params']);
            $sub_query = [];
            foreach ($b as $key => $item) {
                $sub_query[$key] = ' INSTR(movies.area_list, "' . $item . '") > 0 ';
            }
            $sub_query = implode('OR', $sub_query);
            $query .= ' AND (' . $sub_query . ' )';
        }

        if (!empty($valueC)) {
            $c = explode(',', $search_advance_list[$valueA]['screeningItems'][1]['items'][$valueC]['params']);
            $sub_query = [];
            foreach ($c as $key => $item) {
                $sub_query[$key] = ' INSTR(movies.tag_list, "' . $item . '") > 0 ';
            }
            $sub_query = implode('OR', $sub_query);
            $query .= ' AND (' . $sub_query . ' )';
        }

        if (!empty($valueD)) {
            $d = explode(',', $search_advance_list[$valueA]['screeningItems'][2]['items'][$valueD]['params']);

            if ($d[0] === $d[1]) {
                $sub_query = 'movies.year = ' . $d[0];
            } else {
                $sub_query = 'movies.year BETWEEN ' . $d[0] . ' AND ' . $d[1];
            }
            $query .= ' AND (' . $sub_query . ' )';
        }

        $home_movies = Movie::selectRaw('movies.*')->distinct()->join('movie_media', 'movies.id_movie', '=', 'movie_media.movie_id')
            ->whereRaw($query)->where('id_movie', '>', $request->index)->take(12)->get();

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
                              <p class="film__name">' . $movie->name . ' (' . $movie->year . ')</p>
                          </a>';
        }

        $index = $home_movies[count($home_movies) - 1]->id_movie;
        $data = ['movies' => $output, 'index' => $index];
        return response()->json($data);
    }
}
