@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
    @include('templates.header_not_search')
    <div class="main-content">
        <div class="container p0">
            <div class="box-white">
                <form method="POST"  action="{{ url('account/pwd_email') }}" class="form-horizontal form-signup" role="form" accept-charset="utf-8" autocomplete="off">
                    {{csrf_field()}}
                    <div class="signup-title">
                        <span class="title-bor">{{ trans('account.reset_title') }}</span>
                    </div>
                    <h4 class='txc title_msg'>{{ trans('account.Please input your main address for send password reset mail')}}</h4>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row form-group">
                        <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12 lh16">{{ trans('account.register_email') }}</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-input">
                            <input type="email" class="form-control input-signup" placeholder="{{ trans('account.placeholder_register_email') }}" id="email" name="email" value="{{ old('email','') }}" oninvalid="this.setCustomValidity('{{trans('account.please enter a email address')}}')" oninput="setCustomValidity('')">
                        </div>
                    </div>

                    <div class="row form-group txc div-btn">
                        <button type="submit" class="btn btn-orange">{{ trans('account.reset_submit_input') }}</button>
                    </div>
                </form> <!-- /form -->
            </div> <!-- ./container -->
        </div>
    </div>
</div>
@endsection