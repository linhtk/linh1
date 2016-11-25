{!! trans('contact.send_mail_admin_content_1') !!}

{{ $contacts['time'] }}

{!! trans('contact.send_mail_admin_content_2') !!}

{{ $contacts['name'] }}

{!! trans('contact.send_mail_admin_content_3') !!}

{{ $contacts['email'] }}

{!! trans('contact.send_mail_admin_content_4') !!}

{{ $contacts['user_id'] == 0 ? '' : $contacts['user_id'] }}

{!! trans('contact.send_mail_admin_content_5') !!}

{{ \App\Models\Contact::INQUIRY_TYPE[$contacts['inquiry_type']] }}

{!! trans('contact.send_mail_admin_content_6') !!}

{{ $contacts['user_id'] == 0  ? 'visitor' : 'login user' }}

{!! trans('contact.send_mail_admin_content_7') !!}

{{ $contacts['ip'] }}

{!! trans('contact.send_mail_admin_content_8') !!}

{{ $contacts['user_agent'] }}

{!! trans('contact.send_mail_admin_content_9') !!}

{{ $contacts['contents'] }}

{!! trans('contact.send_mail_admin_content_10') !!}