@extends('layouts.master')
@section('meta')
<meta property="og:locale" content="vi_VN">
<meta property="og:type" content="website">
<meta property="og:title" content="{{$movie_detail->name}} - FullHD Vietsub + Thuyết Minh">
<meta property="og:description" content="Xem phim {{$movie_detail->name}} FullHD Vietsub, {{$movie_detail->name}} tập 1, {{$movie_detail->name}} tập cuối - Xem phim ngay tại TopFilm.">
<meta property="og:url" content="">
<meta property="og:site_name" content="{{$movie_detail->name}}">
<meta property="og:image" content="{{$movie_detail->image}}">
<link rel="canonical" href="{{ route('detail_name', $movie_detail->slug) }}/" />
<title>{{$movie_detail->name}} - FullHD Vietsub + Thuyết Minh</title>
<link href="{{ asset('css/video-js.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('css/videojs-seek-buttons.css')}}" />
<style>
	.vjs-menu-item-text {
		text-transform: none;
	}
</style>
@endsection
@section('content')
<section class="movie">
	<div class="box advanced">
		<div class="movie__container">
			<div class="movie__media" id="movie__media">
				<video class="movie__screen video-js" id="video_media" preload="auto" data-setup="{}" controls autoplay>
					<source src="movie" type="application/x-mpegURL">
				</video>
				<div class="movie__load">
					<div id="loading_movie"></div>
				</div>
			</div>
			<h1 class="movie__name" id="{{$movie_detail['name']}}">{{$movie_detail->name}} - FullHD Vietsub + Thuyết Minh
			@if(!is_null($movie_detail->episode_count))
			- Tập {{ $episode }}
			@endif
			</h1>
			@if(!is_null($movie_detail->episode_count))
			<div class="movie__episodes">
            @for($i = 1; $i <= $movie_detail->episode_count; ++$i)
			<a class="episode {{ $i == $episode ? 'active' : '' }}" href="{{ route('detail_name_episode', ['name' => $movie_detail->slug, 'episode' => $i]) }}"> {{ $i }} </a>
            @endfor
			</div>
			@endif
			<div class="movie__info">
				<div class="movie__score"> <i class="fa-solid fa-star"></i> {{$movie_detail->rate}}</div>
				<div class="movie__year"> <i class="fa-solid fa-calendar"></i> {{$movie_detail->year}}</div>
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

		video = videojs('video_media');
		getVideo = setInterval(restart, 1000);

		@if($sub != '')
		fetch("{{$sub}}").then((r) => {
			r.text().then((d) => {
				let srtText = d
				var srtRegex = /(.*\n)?(\d\d:\d\d:\d\d),(\d\d\d --> \d\d:\d\d:\d\d),(\d\d\d)/g;
				var vttText = 'WEBVTT\n\n' + srtText.replace(srtRegex, '$1$2.$3.$4');
				var vttBlob = new Blob([vttText], {
					type: 'text/vtt'
				});
				var blobURL = URL.createObjectURL(vttBlob);
				let captionOption = {
					kind: 'captions',
					srclang: 'vi',
					label: 'Tiếng Việt',
					src: blobURL
				};
				video.addRemoteTextTrack(captionOption);
			})
		})
		@endif

		document.onkeydown = function(event) {
			switch (event.keyCode) {
				case 37:
					event.preventDefault();
					vid_currentTime = video.currentTime();
					video.currentTime(vid_currentTime - 5);
					break;
				case 39:
					event.preventDefault();
					vid_currentTime = video.currentTime();
					video.currentTime(vid_currentTime + 5);
					break;
			}
		};

		video.seekButtons({
			forward: 10,
			back: 10
		});

		function restart() {
			if (video['cache_']['duration'] == 0 || !video['controls_'] || video['error_'] != null || isNaN(video['cache_']['duration']) || video['cache_']['duration'] == 'Infinity') {
				reload();
			} else {
				$('.movie__load').hide();
				if (video.textTracks()['tracks_'].length > 1) {
					video.textTracks()[0].mode = 'showing';
				}
				clearInterval(getVideo);
			}
		}

		function reload() {
			$.ajax({
				url: "{{ route('episode-ajax')}}",
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				type: "POST",
				dataType: 'json',
				data: {
					movie_id: '{{ $movie_detail->id_movie }}',
					episode: '{{ $episode }}',
					_token: '{{ csrf_token() }}'
				}
			}).done(function(data) {
				if (video['cache_']['duration'] == 0 || !video['controls_'] || video['error_'] != null || isNaN(video['cache_']['duration']) || video['cache_']['duration'] == 'Infinity') {
					video.src(data);
				}
				return true;
			}).fail(function(e) {
				return false;
			});
		}
	})
</script>
@endsection