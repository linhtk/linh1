@extends('...layouts.public')

@section('content')

<div class="container">
            <form method="POST" class="form-horizontal" role="form" accept-charset="utf-8">
            {{csrf_field()}}
                <h2>{{ trans('account.login_title') }}</h2>

                @if (count($errors) > 0)
                  <div class="alert alert-danger">
                   {{ trans('account.login_msg_error') }}<br><br>
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">{{ trans('account.login_email') }}</label>
                    <div class="col-sm-9">
                        <input type="email" id="email" name="email" placeholder="Email" class="form-control" value="{{ (old('email', '') != '') ? old('email','') : ( (isset($get_data_login['email']) && trim($get_data_login['email']) != '') ? trim($get_data_login['email']) : '') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="passwd" class="col-sm-3 control-label">{{ trans('account.login_password') }}</label>
                    <div class="col-sm-9">
                        <input type="password" id="passwd" name="passwd" value="{{ (old('passwd', '') != '') ? old('passwd','') : ( (isset($get_data_login['passwd']) && trim($get_data_login['passwd']) != '') ? trim($get_data_login['passwd']) : '') }}" placeholder="Password" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button type="submit" class="btn btn-primary btn-success">{{ trans('account.login_submit') }}</button>
                    </div>
                </div>

            </form> <!-- /form -->
        </div> <!-- ./container -->
@endsection