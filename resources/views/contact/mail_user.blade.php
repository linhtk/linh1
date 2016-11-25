{!! trans('contact.send_mail_user_content_1') !!}

{{ $name }}

{!! trans('contact.send_mail_user_content_2') !!}

{{ \App\Models\Contact::INQUIRY_TYPE[$inquiry_type] }}

{!! trans('contact.send_mail_user_content_3') !!}

{{ $contents }}

{!! trans('contact.send_mail_user_content_4') !!}