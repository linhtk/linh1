<?php
    $get_data_login = array();
?>
@if (Session::has('post_data_from_login'))
   <?php
       $get_data_login = Session::get('post_data_from_login');
   ?>
@endif
<?php 
    $flag_error = false;
     if( !$errors->loginErrors->isEmpty() || Session::has('error_session_expired') ){
        $flag_error = true;
     }
?>
<form method="POST" class="form-horizontal" role="form" accept-charset="utf-8" action="{{url('/account/login')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-lg-6 col-md-6 p0">
        <input type="email" id="login_email" name="login_email" placeholder="{{trans('account.placeholder_register_email')}}" class="form-control input-login<?php if($flag_error) echo ' error';?>" value="{{ (old('login_email', '') != '') ? old('login_email','') : ( (isset($get_data_login['login_email']) && trim($get_data_login['login_email']) != '') ? trim($get_data_login['login_email']) : '') }}">
        @if ( $flag_error == true )
          <i class="fa fa-exclamation-circle icon-warning" aria-hidden="true"></i>
          <div class='message-error'>
              @if ( !$errors->loginErrors->isEmpty() )
                  @foreach ($errors->loginErrors->all() as $error)
                      {{ $error }}<br>
                  @endforeach
              @endif
              @if(Session::has('error_session_expired'))
                  {{Session::get('error_session_expired')}}
              @endif
          </div>
        @endif
        <div id="alert_login_err" class="alert_login_err">
             <i class="fa fa-exclamation-circle detail_login_icon-warning" aria-hidden="true"></i>
             <div class='detail_login_message-error' id="detail_message-error"></div>
        </div>
        <input type="password" id="login_passwd" name="login_passwd" value="{{ (old('login_passwd', '') != '') ? old('login_passwd','') : ( (isset($get_data_login['login_passwd']) && trim($get_data_login['login_passwd']) != '') ? trim($get_data_login['login_passwd']) : '') }}" placeholder="{{trans('account.placeholdern_register_password')}}" class="form-control input-login mt8 <?php if($flag_error) echo ' error';?>">
        @if ( $flag_error == true )
            <i class="fa fa-exclamation-circle icon-warning icon-top" aria-hidden="true"></i>
        @endif
        <p class="mt6 txr"><a href="{{ url('/account/pwd_email') }}" class=" italic fs11 underline  txt-44 ">{{trans('toppage.forget_password')}}</a></p>
    </div>
    <div class="col-lg-6 col-md-6 p0 pl10 txr lo-si">
      <button class="btn btn-log-in">{{trans('toppage.LOGIN')}}</button>
      <a href='{{ url('/account/register') }}' class="btn btn-sign-up ml10">{{trans('toppage.SIGNUP')}}</a>
    </div>
</form> <!-- /form -->

<script type="text/javascript">
$(document).ready(function(){
   $("#alert_login_err").hide();

});
</script>


