@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
    @include('templates.header_not_search')

     <div class="main-content">
        <div class="container p0">
            <div class="box-white">
                <form method="POST"  action="{{ URL::route('account.pwd_verify', array('token_pwd'=>$token_pwd)) }}" class="form-horizontal form-signup" role="form" accept-charset="utf-8">
            {{csrf_field()}}
                
                    <div class="signup-title">
                        <span class="title-bor">{{ trans('account.reset_title') }}</span>
                    </div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row form-group group-first">
                        <label class="label-control col-lg-3 col-md-3 col-sm-2 col-xs-12 lh16">{{ trans('account.login_password') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 div-input">
                            <input type="password" class="form-control input-signup" placeholder="{{ trans('account.placeholdern_register_password') }}" id="passwd" name="passwd" value="{{ old('passwd','') }}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-2 col-xs-12 lh16">{{ trans('account.register_password_retype') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 div-input">
                            <input type="password" class="form-control input-signup" placeholder="{{ trans('account.placeholder_password_retype') }}" id="retype_passwd" name="retype_passwd" value="{{ old('retype_passwd','') }}">
                        </div>
                    </div>
                    <div class="row form-group txc div-btn-con">
                        <button type="submit" class="btn btn-orange">{{ trans('account.reset_submit_finish') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- ./container -->
</div>
@endsection