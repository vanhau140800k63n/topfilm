@extends('layouts.master')
@section('meta')
    <meta property="og:locale" content="vi_VN">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $movie_detail->name }} - FullHD Vietsub + Thuyết Minh">
    <meta property="og:description"
        content="Xem phim {{ $movie_detail->name }} FullHD Vietsub, {{ $movie_detail->name }} tập 1, {{ $movie_detail->name }} tập cuối - Xem phim ngay tại TopFilm.">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="{{ $movie_detail->name }}">
    <meta property="og:image" content="{{ $movie_detail->image }}">
    <link rel="canonical" href="{{ route('detail_name', $movie_detail->slug) }}/" />
    <title>{{ $movie_detail->name }} - FullHD Vietsub + Thuyết Minh</title>
    <link href="{{ asset('css/video-js.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/videojs-seek-buttons.css') }}" />
    <style>
        .vjs-menu-item-text {
            text-transform: none;
        }
    </style>
@endsection
@section('content')
    <section class="movie" style="margin-top: 0">
        <div class="movie_frame">
            <div class="movie_cover"></div>
			<div class="movie_cover1"></div>
			<div class="movie_cover2"></div>
            <iframe src="https://loklok.com/detail/{{ $movie_detail->category }}/{{ $movie_detail->id }}"
                style="width: 100%; margin-top: 100px; height: 700px"></iframe>
        </div>
        <div class="box advanced">
            <div class="movie__container">
                {{-- <div class="movie__media" id="movie__media">
				<video class="movie__screen video-js" id="video_media" preload="auto" data-setup="{}" controls autoplay>
					<source src="movie" type="application/x-mpegURL">
				</video>
				<div class="movie__load">
					<div id="loading_movie"></div>
				</div>
			</div> --}}
                <h1 class="movie__name" id="{{ $movie_detail['name'] }}">{{ $movie_detail->name }} - FullHD Vietsub +
                    Thuyết Minh
                    @if (!is_null($movie_detail->episode_count))
                        - Tập {{ $episode }}
                    @endif
                </h1>
                @if (!is_null($movie_detail->episode_count))
                    <div class="movie__episodes">
                        @for ($i = 1; $i <= $movie_detail->episode_count; ++$i)
                            <a class="episode {{ $i == $episode ? 'active' : '' }}"
                                href="{{ route('detail_name_episode', ['name' => $movie_detail->slug, 'episode' => $i]) }}">
                                {{ $i }} </a>
                        @endfor
                    </div>
                @endif
                <div class="movie__info">
                    <div class="movie__score"> <i class="fa-solid fa-star"></i> {{ $movie_detail->rate }}</div>
                    <div class="movie__year"> <i class="fa-solid fa-calendar"></i> {{ $movie_detail->year }}</div>
                </div>
                <div class="movie__tag"></div>
                <div class="movie__intro">{!! $movie_detail->description !!}</div>
                <div class="recommend__items__title">
                    <div class="recommend__items__name" style="max-width: 100%">
                        <span>Phim ngẫu nhiên</span>
                    </div>
                </div>
                <div class="recommend__item">
                </div>
            </div>
            <div class="movie__similar">
            </div>
        </div>
    </section>
    <script src="{{ asset('js/video.min.js') }}"></script>
    <script src="{{ asset('js/videojs-seek-buttons.js') }}"></script>
    <script src="{{ asset('js/videojs-seek-buttons.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.movie__media').height($('.movie__media').width() * 1080 / 1920);
            $('.movie__load').height($('.movie__media').height() + 5);
        })
    </script>
@endsection
