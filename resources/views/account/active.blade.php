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
	                <span class="title-bor">{{trans('toppage.Create account')}}</span>
	            </div>
	            <div class="div-step row">
	                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-step">
	                    <a class="name-step active done" href="{{url('/account/register')}}">
	                        <div class="step-num">1</div>
	                        <div class="txt-step">{{ trans('account.step_1') }}</div>
	                    </a>
	                </div>

	                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-step">
	                    <a class="name-step active done" href="#">
	                        <div class="step-num">2</div>
	                        <div class="txt-step">{{ trans('account.step_2') }} </div>
	                    </a>
	                </div>

	                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-step">
	                    <a class="name-step active" href="#">
	                        <div class="step-num">3</div>
	                        <div class="txt-step">{{ trans('account.step_3') }}</div>
	                    </a>
	                </div>

	                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-step">
	                    <a class="name-step" href="#">
	                        <div class="step-num">4</div>
	                        <div class="txt-step">{{ trans('account.step_4') }}</div>
	                    </a>
	                </div>
	            </div>
                <div class="form-horizontal form-signup info-confirm">
					<div class="title-su-orange">{{ trans('account.step_3') }}</div>
					<div class='row form-group group-first txc'>
				       	{{ trans('account.active_text_1') }}<br/>
				       	{{ trans('account.active_text_2') }}
				   </div>
				   <div class="row form-group txc div-btn-con">
                    	<a href="{{url('/')}}" class="btn btn-orange"> {{ trans('account.active_text_3') }} </a>
	                </div>
                </div>
	        </div>
	    </div>
	</div>
</div>
@endsection