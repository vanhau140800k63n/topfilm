<header>
	<div class="box">
		<div class="logo glow"><a href="{{route('home')}}">TOPFILM</a></div>
		<div class="search">
			<form action="" method="post">
				@csrf
				<input type="text" name="keyword" placeholder="Tên phim ..." class="search__input">
				<button class="search__btn">Tìm kiếm</button>
			</form>
		</div>
		<?php 
		$search_advanced_list = \App\Constants\AdvancedSearch::SEARCH_LIST;
		?>
		<div class="advanced_search">
			@foreach($search_advanced_list as $as_key => $as_container)
			<div class="as_name" id_key="{{$as_key}}">{{$as_container['name']}} <i class="fa-solid fa-caret-down"></i>
		    </div>

			<div class="as_container" id="as_container{{$as_key}}" params="{{$as_container['params']}}">
				@foreach($as_container['screeningItems'] as $key_screening_items => $screening_items)
					<div class="as_items" index="as_{{$screening_items['id']}}">
						@if($key_screening_items < 3) <div class="as_items_name"> {{ __('search_advanced.'. $screening_items['name'])}}</div>
							@foreach($screening_items['items'] as $key_as_items=> $as_item)
							<div class="as_item" value="{{$as_item['params']}}" screening_type="{{$as_item['screeningType']}}" check="{{$as_key.'.'.$as_item['screeningType'].'#'.$as_item['params']}}">
								@if (trans()->has('search_advanced.detail.' . $as_item['name']))
								{{ __('search_advanced.detail.'. $as_item['name'])}}
								@else
								{{ $as_item['name'] }}
								@endif
							</div>
							@endforeach
						@endif
				    </div>
			    @endforeach
			    <div class="close_search_advanced">
					<button class="close_search_advanced_btn">Đóng</button>
				</div>
			</div>
			@endforeach
		</div>
	</div>
	<div id="preloader">
		<div id="loader"></div>
	</div>
</header>
<script>
	$('.as_name').hover(function() {
		$('.as_container').each(function() {
			$(this).hide();
		})
		$('.as_name').each(function() {
			$(this).css('color', '#fff');
			$(this).css('background', 'none');
		})
		$('#as_container' + $(this).attr('id_key')).show();
		$(this).css('color', '#000');
		$(this).css('background', '#fff');
	}, function() {
		if ($('#as_container' + $(this).attr('id_key') + ':hover').length == 0) {
			$('#as_container' + $(this).attr('id_key')).hide();
			$(this).css('color', '#fff');
			$(this).css('background', 'none');
		}
	})
	$('.as_container').mouseout(function() {
		if ($('.as_container div:hover').length == 0) {
			$(this).hide();
			$('.as_name').each(function() {
				$(this).css('color', '#fff');
				$(this).css('background', 'none');
			})
		}
	})

	$('.close_search_advanced').click(function() {
		$(this).parent().hide();
		$('.as_name').each(function() {
			$(this).css('color', '#fff');
			$(this).css('background', 'none');
		})
	})
</script>