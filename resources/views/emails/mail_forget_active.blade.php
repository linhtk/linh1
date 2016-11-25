<h3>
{!! trans('emails.pwd_reset_title_1') !!}
</h3>
<p></p>
<p>

{!! trans('emails.pwd_reset_text_1', ['email' => $email]) !!}

{{ URL::route('account.pwd_verify', array('token_pwd'=>$token_pwd)) }}
<br><br/>

{!! trans('emails.pwd_reset_text_2') !!}

</p>

