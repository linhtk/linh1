<div class="banner-slider" >
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			@if ( count($carousels) > 0 )
				@foreach($carousels as $key => $carousel)
					<li data-target="#myCarousel" data-slide-to="{{$key}}" class='<?php if( $key == 0 ) echo 'active';?>'></li>
				@endforeach
			@endif
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			@if ( count($carousels) > 0 )
				@foreach($carousels as $key => $carousel)
					<div class="item<?php if( $key == 0 ) echo ' active';?>">
						<img src="{{$carousel->banner_path}}">
					</div>
				@endforeach
			@endif
		</div>

		<!-- Left and right controls -->
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
			<span class="sr-only">Next</span>
		</a>
	  </div>
</div>