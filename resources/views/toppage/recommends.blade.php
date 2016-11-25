<!-- Recommend Item -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p0">
	<div class="title-item">{{trans('toppage.Recommended Items')}}</div>
</div>
<div class="clearfix"></div>

<div class="row items-list no-slider">							
	<div class="list-recom col-sm-12">
		@if ( count($recommends) > 0 )
			@foreach($recommends as $recommend)
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 item-box">
					<div class="col-sm-12 col-xs-12 img-item">
						<?php $image_path = Utils::getPathImageCampain('banner/'.$recommend->image_filename );?>
						<a class="" href="{{ URL::route('toppage.detail', array('c_id'=>$recommend->campaign_id,'t_id'=>$recommend->t_id))}}"><img class="img-item-recommended" src="{{$image_path}}"> </a>
					</div>
					<div class="col-sm-12 col-xs-12 txt-item">
						<div class="txt-over">
							{{$recommend->promotion_name}}
						</div>
						<div class="bot-sec">
							<div class="txt-highlight">
								@if($recommend->thanks_type == 3)
									<p> {{$recommend->normal_price}} {{trans('toppage.point')}}</p>
								@elseif($recommend->thanks_type == 4)
									<p> {{$recommend->normal_price}} %</p>
								@endif
							</div>
							<div class="bor-gray"></div>
							<a class="btn btn-white" href="{{ URL::route('toppage.detail', array('c_id'=>$recommend->campaign_id,'t_id'=>$recommend->t_id))}}">{{ trans('toppage.discovery_tasks') }} <i class="fa fa-angle-double-right txt-orange fs18 mr10" aria-hidden="true"></i> </a>
						</div>
					</div>
				</div>
			@endforeach
		@else
			 <div class='campaign_not_found'>{{trans('toppage.campaign not recommended')}}</div>
		@endif
	</div>
</div>
<!-- End Recommend Item  -->