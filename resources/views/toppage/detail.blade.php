@extends('templates.master')
@section('content')
@include('templates.right_menu_for_mb')
<div id="main">
	@include('templates.header')
	<!-- Main content -->
	<div class="main-content">
		<div class="items-block category-p">
			<div class="container p0">
				<div class="row recom-item detail-p">
					@include('templates.sidebar')
					<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 categories-right">
						@if ( count($campaign) > 0 )
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p0">
							<a class="repo-link font600" href="/category/{{$campaign->category_id}}">{{$category_name}}</a> > <span class="repo-link">{{$campaign->advertiser_name}} - {{$campaign->promotion_name}}</span>
							</div>
							<div class="clearfix"></div>
							<div class="row detail-cate">							
								<div class="col-sm-12">
								
									<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 img-detail">
										<div class="col-sm-12 col-xs-12 img-item">
											<?php $image_path = Utils::getPathImageCampain('banner/'.$campaign->image_filename );?>
											<a class="" href="#"><img class="" src="{{$image_path}}"> </a>
										</div>
										<div class="col-sm-12 col-xs-12 txt-qc">
											<div class="txt-highlight"> 
												@if($campaign->thanks_type == 3)
													<p> {{$campaign->normal_price}} {{trans('toppage.point')}}</p>
												@elseif($campaign->thanks_type == 4)
													<p> {{$campaign->normal_price}} %</p>
												@endif
											</div>
											<div class="bor-gray"></div>
											<a target="_blank" href="{{ URL::route('toppage.civi', array('c_id'=>$campaign->campaign_id,'t_id'=>$campaign->t_id))}}" class="btn btn-white btn_give_effect">{{trans('toppage.conquer_tasks')}}  <i class="fa fa-angle-double-right txt-orange fs18 mr10" aria-hidden="true"></i> </a>
											<p class="font600 mt20">{{trans('toppage.Note')}}:</p>
											<?php echo $campaign->detail_media;?>
										</div>
									</div>
									
									<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 txt-detail">
										<div class="title-detail">{{$campaign->advertiser_name}} - {{$campaign->promotion_name}}</div>
										<p>
											<?php echo $campaign->detail_enduser;?>
										</p>
										<p>
											<?php echo $campaign->certificate_condition;?>
										</p>
										<p>
											<?php echo $campaign->condition_reward;?>
										</p>
										<div class="visible-xs mt30">
											<a target="_blank" href="{{ URL::route('toppage.civi', array('c_id'=>$campaign->campaign_id,'t_id'=>$campaign->t_id))}}" class="btn btn-white btn_give_effect">{{trans('toppage.conquer_tasks')}} <i class="fa fa-angle-double-right txt-orange fs18 mr10" aria-hidden="true"></i> </a>
										</div>
									</div>									
								</div>
							</div>	
						@else
							{{trans('toppage.campaign not found')}}
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
