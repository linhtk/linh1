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
				{{ Form::open(array('url' => '/contact/submit', 'class' => 'form-horizontal form-signup form-contact info-confirm')) }}
					@if (!$errors->contactErrors->isEmpty())
                        <div class="alert alert-danger">
                            <ul>
		                  		@foreach ($errors->contactErrors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="title-su-orange">{{ trans('contact.confirm') }}</div>
					<div class="form-group group-first">
						{{ Form::label('name', trans('contact.name'), ['class' => 'label-control col-lg-2 col-md-2 col-sm-2 col-xs-6']) }}
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
							<p class="area-txt-conf">{{ $params['name'] }}</p>
	                        {{ Form::hidden('name',$params['name']) }}
	                    </div>
					</div>
					<div class="form-group">
						{{ Form::label('email', trans('contact.email'), ['class' => 'label-control col-lg-2 col-md-2 col-sm-2 col-xs-6']) }}
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
							<p class="area-txt-conf">{{ $params['email'] }}</p>
							{{ Form::hidden('email',$params['email']) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('inquiry_type', trans('contact.inquiry_type'), ['class' => 'label-control col-lg-2 col-md-2 col-sm-2 col-xs-6']) }}
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
							<p>{{ \App\Models\Contact::INQUIRY_TYPE[$params['inquiry_type']] }}</p>
							{{ Form::hidden('inquiry_type', $params['inquiry_type']) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('contents', trans('contact.contents'), ['class' => 'label-control col-lg-2 col-md-2 col-sm-2 col-xs-6']) }}
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
							<p class="area-txt-conf">{{ $params['contents'] }}</p>
							{{ Form::hidden('contents',$params['contents']) }}
						</div>
					</div>
					@if(Session::get('contact_times') > \App\Models\Contact::CONTACT_TIMES_MAX)
						{{ Form::hidden('captcha', $params['captcha']) }}
					@endif
					<div class="form-group txc div-btn" style="text-align:center;">
						<a href="/contact" class="btn btn-white-00 width150"> {{ trans('contact.back') }} </a>
						<button type="submit" name="submit" value="submit" class="btn btn-orange width150">{{ trans('contact.submit') }}</button>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>


@endsection