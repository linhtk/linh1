<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p0">
	<div class="title-item padding-lr-10">{{trans('toppage.Spotlight Items')}}</div>
</div>
<div class="clearfix"></div>
<!-- Spotlight Item for PC -->
<div class="row items-list hidden-xs hidden-sm">
	@if ( count($spotLights) > 0 )
		@foreach($spotLights as $spotLight)
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 item-box">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 img-item">
					<?php $image_path = Utils::getPathImageCampain('banner/'.$spotLight->image_filename );?>
					<a class="" href="{{ URL::route('toppage.detail', array('c_id'=>$spotLight->campaign_id,'t_id'=>$spotLight->t_id))}}"><img class="" src="{{$image_path}}"> </a>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 txt-item">
					<div class="txt-over">
						{{$spotLight->promotion_name}}
					</div>
					<div class="bot-sec">
						<div class="txt-highlight">
								@if($spotLight->thanks_type == 3)
									<p> {{$spotLight->normal_price}} {{trans('toppage.point')}}</p>
								@elseif($spotLight->thanks_type == 4)
									<p> {{$spotLight->normal_price}} %</p>
								@endif
							</div>
						<div class="bor-gray"></div>
						<a class="btn btn-white" href="{{ URL::route('toppage.detail', array('c_id'=>$spotLight->campaign_id,'t_id'=>$spotLight->t_id))}}">{{trans('toppage.discovery_tasks')}} <i class="fa fa-angle-double-right txt-orange fs18 mr10" aria-hidden="true"></i> </a>
					</div>
				</div>
			</div>
		@endforeach
	@else
		<div class='campaign_not_found'>{{trans('toppage.campaign not spotLights')}}</div>
	@endif
</div>
<!-- End Spotlight Item for PC -->
									
<!-- Spotlight Item for Tablet and Mobile -->
<div class="row items-list hidden-md">
	<div class="container p0">
		<section class="regular slider">
			@if ( count($spotLights) > 0 )
				@foreach($spotLights as $spotLight)
					<div class="col-sm-6 col-xs-12 item-box">
						<div class="col-sm-12 col-xs-12 img-item">
							<?php $image_path = Utils::getPathImageCampain('banner/'.$spotLight->image_filename );?>
							<a class="" href="{{ URL::route('toppage.detail', array('c_id'=>$spotLight->campaign_id,'t_id'=>$spotLight->t_id))}}"><img class="" src="{{$image_path}}"> </a>
						</div>
						<div class="col-sm-12 col-xs-12 txt-item">
							{{$spotLight->promotion_name}}
							<div class="txt-highlight">
								@if($spotLight->thanks_type == 3)
									<p> {{$spotLight->normal_price}} {{trans('toppage.point')}}</p>
								@elseif($spotLight->thanks_type == 4)
									<p> {{$spotLight->normal_price}} %</p>
								@endif
							</div>
							<div class="bor-gray"></div>
							<a class="btn btn-white" href='{{ URL::route('toppage.detail', array('c_id'=>$spotLight->campaign_id,'t_id'=>$spotLight->t_id))}}'>{{trans('toppage.discovery_tasks')}} <i class="fa fa-angle-double-right txt-orange fs18 mr10" aria-hidden="true"></i> </a>
						</div>
					</div>
				@endforeach
			@else
				<div class='campaign_not_found'>{{trans('toppage.campaign not spotLights')}}</div>
			@endif
		</section>
	</div>
</div>
<!-- End Spotlight Item for Tablet and Mobile -->