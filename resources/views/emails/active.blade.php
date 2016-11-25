<h3>
{!! trans('emails.register_title_1') !!}
</h3>
<p></p>
<p>

{!! trans('emails.register_text_1', ['email' => $email]) !!}

{{ URL::route('account.verify', array('token'=>$token))}}
<br><br/>

{!! trans('emails.register_text_2') !!}

</p>

