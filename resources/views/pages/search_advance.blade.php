@extends('layouts.master')
@section('meta')
@endsection
@section('content')
<div class="box search_advance" index="{{ $index }}">
	<div class="recommend__item">
		@foreach($home_movies as $movie)
		<a href="{{route('detail_name', $movie->slug)}}" class="card__film">
			<?php
			if ($movie->image == '' || $movie->image == null) {
				$url_image = asset('img/' . $movie->category . $movie->id . '.jpg');
			} else {
				$url_image = $movie->image;
			}
			?>
			<img class="image" src="{{$url_image}}" alt="image" />
			<p class="film__name">{{$movie->name}} ({{ $movie->year }})</p>
		</a>
		@endforeach
	</div>
	<div class="text-center">
		<div class="lds-facebook">
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>
</div>
<script>
	var scroll = true;
	$(window).scroll(function() {
		if ($('.box').hasClass('search_advance')) {
			value = $('header').height() + $(".search_advance").height() - $(window).scrollTop() - $(window).height() - 1000;
			if (value < 0 && scroll) {
				scroll = false;
				let _token = $('input[name="_token"]').val();
				$.ajax({
					url: "{{route('search_advanced_more')}}",
					type: "POST",
					dataType: 'json',
					data: {
						index: $('.search_advance').attr('index'),
						value: "{{ $value }}",
						width: $('.image').width(),
						_token: _token
					}
				}).done(function(data) {
					$('.recommend__item').html($('.recommend__item').html() + data['movies']);
					$('.search_advance').attr('index', data['index']);
					$('.image').css('max-height', $('.card__film').width() * 1.4);
					$('#preloader').hide();
					scroll = true;

					return true;
				}).fail(function(e) {
					return false;
				});
			}
		}
	});
</script>
@endsection