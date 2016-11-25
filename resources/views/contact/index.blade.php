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
				{{ Form::open(array('url' => '/contact/preview', 'class' => 'form-horizontal form-signup')) }}
					<?php
						if (isset($params)) {
							$name = $params['name'];
							$email = $params['email'];
						} elseif (Auth::check()){
							$name = Auth::user()->name;
							$email = Auth::user()->email;
						} else {
							$name = '';
							$email = '';
						}
					?>
					@if (!$errors->contactErrors->isEmpty())
                        <div class="alert alert-danger">
                            <ul>
		                  		@foreach ($errors->contactErrors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="title-su-orange">{{ trans('contact.input_form') }}</div>
					<div class="form-group group-first mt10-mb">
						{{ Form::label('name', trans('contact.name'), ['class' => 'col-sm-2 control-label']) }}
						<div class="col-sm-9">
							{{ Form::text('name', $name, ['readonly' => Auth::check() ? true : null, 'class' => 'form-control input-signup', 'placeholder' => trans('contact.placeholder_name')]) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('email', trans('contact.email'), ['class' => 'col-sm-2 control-label']) }}
						<div class="col-sm-9">
							{{ Form::text('email', $email, ['readonly' => Auth::check() ? true : null, 'class' => 'form-control input-signup', 'placeholder' => trans('contact.placeholder_email')]) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('inquiry_type', trans('contact.inquiry_type'), ['class' => 'col-sm-2 control-label']) }}
						<div class="col-sm-9">
							{{ Form::select('inquiry_type', \App\Models\Contact::INQUIRY_TYPE, isset($params) ? $params['inquiry_type'] : null, ['class' => 'form-control input-signup']) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('contents', trans('contact.contents'), ['class' => 'col-sm-2 control-label']) }}
						<div class="col-sm-9">
							{{ Form::textarea('contents', isset($params) ? $params['contents'] : '', ['class' => 'form-control txtarea-signup', 'placeholder' => trans('contact.placeholder_contents')]) }}
						</div>
					</div>
					@if(Session::get('contact_times') > \App\Models\Contact::CONTACT_TIMES_MAX)
						<div class="form-group">
							{{ Form::label('captcha', trans('contact.captcha'), ['class' => 'col-sm-2 control-label']) }}
							<div class="col-sm-4">
								{{ Form::text('captcha', '', ['class' => 'form-control input-signup']) }} 
							</div>
							<a href="javascript:void(0)" onclick="refreshCaptcha()">
								{!! Html::image('img/refresh-captcha.png', 'Refresh', ['width' => 40, 'height' => 40]) !!}
							</a>
							<span class="refreshrecaptcha">
								{!! captcha_img('flat') !!}
							</span>
						</div>
					@endif
					<div class="form-group txc div-btn" style="text-align:center;">
						<button type="submit" name="submit" value="submit" class="btn btn-orange mt15">{{ trans('contact.preview') }}</button>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>


@endsection

<script>
function refreshCaptcha(){
$.ajax({
url: "/refreshrecaptcha",
type: 'get',
  dataType: 'html',        
  success: function(json) {
    $('.refreshrecaptcha').html(json);
  },
  error: function(data) {
    alert('Try Again.');
  }
});
}
</script>