@extends('layouts.master')
@section('meta')
<meta property="og:locale" content="vi_VN">
<meta property="og:type" content="website">
<meta property="og:title" content="TOPFILM - Xem phim FullHD Vietsub mới nhất">
<meta property="og:description" content="Topfilm là website phát các chương trình truyền hình, phim, hoạt hình từ khắp nơi trên thế giới, với phụ đề vietsub và chất lượng hình ảnh fullhd, và các bộ phim mới được phát hành hàng ngày! - topfilm">
<meta property="og:url" content="{{route('home')}}">
<meta property="og:site_name" content="TOPFILM - Xem phim FullHD Vietsub mới nhất">
<meta property="og:image" content="{{ asset('css/assets/images/banner/no-banner.jpg') }}">
<title>TOPFILM - Xem phim FullHD Vietsub mới nhất</title>
@endsection
@section('content')
<div class="box homepage" index="{{ $index }}">
	<div class="loader_home">
		<div class="inner one"></div>
		<div class="inner two"></div>
		<div class="inner three"></div>
	</div>
	<div class="listfilm">
		<div class="listfilm__top">
			<div class="categorys">
				<a data="1" class="home__category">Phim hành động</a>
				<a data="19" class="home__category">Khoa học viễn tưởng</a>
				<a data="3" class="home__category">Hoạt hình</a>
				<a data="13" class="home__category">Kinh dị</a>
				<a data="5" class="home__category">Hài kịch</a>
				<a data="64" class="home__category">Thảm khốc</a>
				<a data="24" class="home__category">Chiến tranh</a>
			</div>
			<div class="swiper__slider">
				<div class="swiper mySwiper">
					<div class="swiper-wrapper">
						<div class="swiper-slide rounded-xl">
							<img class="banner_img" src="{{ asset('/image/banner/banner1.jpg') }}" alt="image" />
						</div>
						<div class="swiper-slide rounded-xl">
							<img class="banner_img" src="{{ asset('/image/banner/banner2.jpg') }}" alt="image" />
						</div>
					</div>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
					<div class="swiper-pagination"></div>
				</div>
			</div>
		</div>
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
				<p class="film__name">{{$movie->name}}</p>
			</a>
			@endforeach
		</div>
	</div>
	<div class="top_search">
		<div class="top_search__title">Top tìm kiếm</div><a href="https://topfilm.devsne.vn/phim-big-mouth-full-hd-vietsub-121348.html" class="top_search__card"><img src="{{ asset('img/121348top_search.jpg') }}" class="top_search__card__img">
			<div class="top_search__card__name">Big Mouth</div>
		</a><a href="https://topfilm.devsne.vn/phim-one-piece-dao-hai-tac-full-hd-vietsub-18220.html" class="top_search__card"><img src="{{ asset('img/18220top_search.jpg') }}" class="top_search__card__img">
			<div class="top_search__card__name">One Piece: Đảo Hải Tặc</div>
		</a><a href="https://topfilm.devsne.vn/phim-transit-love-season-2-full-hd-vietsub-121827.html" class="top_search__card"><img src="{{ asset('img/121827top_search.jpg') }}" class="top_search__card__img">
			<div class="top_search__card__name">Transit Love Season 2</div>
		</a><a href="https://topfilm.devsne.vn/phim-ha-canh-khan-cap-full-hd-vietsub-025093.html" class="top_search__card"><img src="{{ asset('img/025093top_search.jpg') }}" class="top_search__card__img">
			<div class="top_search__card__name">Hạ Cánh Khẩn Cấp</div>
		</a><a href="https://topfilm.devsne.vn/phim-thor-tinh-yeu-va-sam-set-full-hd-vietsub-022995.html" class="top_search__card"><img src="{{ asset('img/022995top_search.jpg') }}" class="top_search__card__img">
			<div class="top_search__card__name">Thor: Tình Yêu Và Sấm Sét</div>
		</a><a href="https://topfilm.devsne.vn/phim-youth-mt-full-hd-vietsub-125156.html" class="top_search__card"><img src="{{ asset('img/125156top_search.jpg') }}" class="top_search__card__img">
			<div class="top_search__card__name">Youth MT</div>
		</a><a href="https://topfilm.devsne.vn/phim-little-women-full-hd-vietsub-123842.html" class="top_search__card"><img src="{{ asset('img/123842top_search.jpg') }}" class="top_search__card__img">
			<div class="top_search__card__name">Little Women</div>
		</a><a href="https://topfilm.devsne.vn/phim-good-job-full-hd-vietsub-124125.html" class="top_search__card"><img src="{{ asset('img/124125top_search.jpg') }}" class="top_search__card__img">
			<div class="top_search__card__name">Good Job</div>
		</a>
	</div>
</div>
<script>
	let swiper__slider_img_width = $('.swiper__slider img').width();
	let swiper__slider_img_height = $('.swiper__slider img').height();

	let position = (swiper__slider_img_width - swiper__slider_img_height / 2.5) / 2;

	$('.swiper__slider img').css('object-position', '0px -' + position + 'px');

	$('.loader_home').remove();

	var swiper = new Swiper(".mySwiper", {
		cssMode: true,
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		pagination: {
			el: ".swiper-pagination",
		},
		mousewheel: true,
		keyboard: true,
	});


	var scroll = true;
	$(window).scroll(function() {
		if ($('.box').hasClass('homepage')) {
			value = $('header').height() + $(".homepage").height() - $(window).scrollTop() - $(window).height() - 1000;
			if (value < 0 && scroll) {
				scroll = false;
				let _token = $('input[name="_token"]').val();
				$.ajax({
					url: "{{route('home-ajax')}}",
					type: "POST",
					dataType: 'json',
					data: {
						index: $('.homepage').attr('index'),
						_token: _token
					}
				}).done(function(data) {
					$('.recommend__item').html($('.recommend__item').html() + data['movies']);
					$('.homepage').attr('index', data['index']);
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