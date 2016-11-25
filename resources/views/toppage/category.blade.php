@extends('templates.master')
@section('content')
@include('templates.right_menu_for_mb')
<div id="main">
	@include('templates.header')
	<!-- Main content -->
	<div class="main-content">
		<div class="items-block category-p">
			<div class="container p0">
				<div class="row recom-item">
					@include('templates.sidebar')
					<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 categories-right">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p0">
							<div class="title-item">{{$category_name}}</div>
						</div>
						<div class="clearfix"></div>

						<div class="row items-list no-slider">		
							@if ( count($campaigns) > 0 )					
								<div class="list-recom col-sm-12">
									@foreach($campaigns as $campaign)
										<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 item-box">
											<div class="col-sm-12 col-xs-12 img-item">
												<a class="" href="{{ URL::route('toppage.detail', array('c_id'=>$campaign->campaign_id,'t_id'=>$campaign->t_id))}}"><img class="img-item-recommended" src="/banner/{{$campaign->image_filename}}"> </a>
											</div>
											<div class="col-sm-12 col-xs-12 txt-item">
												<div class="txt-over">
												{{$campaign->promotion_name}}
											</div>
												<div class="bot-sec">
													<div class="txt-highlight">
														@if($campaign->thanks_type == 3)
															<p> {{$campaign->normal_price}} {{trans('toppage.point')}}</p>
														@elseif($campaign->thanks_type == 4)
															<p> {{$campaign->normal_price}} %</p>
														@endif
													</div>
													<div class="bor-gray"></div>
													<a class="btn btn-white" href="{{ URL::route('toppage.detail', array('c_id'=>$campaign->campaign_id,'t_id'=>$campaign->t_id))}}">{{trans('toppage.discovery_tasks')}} <i class="fa fa-angle-double-right txt-orange fs18 mr10" aria-hidden="true"></i> </a>
												</div>
											</div>
										</div>
									@endforeach
								</div>
								<div class='row page-item'><?php echo $campaigns->links(); ?></div>
							@else
								<div class='campaign_not_found'>{{trans('toppage.campaign not found')}}</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop