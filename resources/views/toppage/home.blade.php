@extends('templates.master')
@section('content')
@include('templates.right_menu_for_mb')
<div id="main">
	@include('templates.header')
	<!-- Main content -->
	<div class="main-content">
		<div class="container p0">
			@include('templates.carousel')
		</div>
		<div class="items-block">
			<div class="container p0">
				@include('toppage.spotlight')
				<div class="row recom-item">
					@include('templates.sidebar')
					<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 categories-right">
						@include('toppage.recommends')
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).on('ready', function() {
		if($(window).width() <=992 && $(window).width() >= 768 ){
			$(".regular").slick({
				dots: true,
				infinite: true,
				slidesToShow: 2,
				slidesToScroll: 2
			});
		}else{
			$(".regular").slick({
				dots: true,
				infinite: true
			});
		}
	});
</script>
@stop