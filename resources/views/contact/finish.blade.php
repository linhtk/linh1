@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
	@include('templates.header_not_search')
	<!-- Main content -->
	<div class="main-content">
		<div class="container p0">
			<div class="box-white">
		        <div class="signup-title">
	                <span class="title-bor">{{ trans('contact.inquiry') }}</span>
	            </div><br>
				<div class="form-horizontal form-submit form-signup form-contact info-confirm">

		            <div style="text-align: center;">
		            	<p class="txt-term">{!! trans('contact.finish_notif') !!}</p>
		            </div>
	                <div class="title-su-orange">{{ trans('contact.finish') }}</div>
					<div class="form-group group-first">
						<label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-6">{{ trans('contact.name') }}</label>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
	                        <p class="area-txt-conf">{{ $params['name'] }}</p>
	                    </div>
					</div>
					<div class="form-group">
						<label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-6">{{ trans('contact.email') }}</label>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
							<p class="area-txt-conf">{{ $params['email'] }}</p>
						</div>
					</div>
					<div class="form-group">
						<label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-6">{{ trans('contact.inquiry_type') }}</label>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
							<p>{{ \App\Models\Contact::INQUIRY_TYPE[$params['inquiry_type']] }}</p>
						</div>
					</div>
					<div class="form-group">
						<label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-6">{{ trans('contact.contents') }}</label>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
							<p class="area-txt-conf">{{ $params['contents'] }}</p>
						</div>
					</div>
					<div class="form-group div-btn" style="text-align:center;">
						<a href="/" class="btn btn-white-00"> {{ trans('contact.back_to_top') }} </a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection