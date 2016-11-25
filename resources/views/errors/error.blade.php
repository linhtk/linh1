
@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
    @include('templates.header_not_search')
<!-- Main content -->

<div class="main-content">
    <div class="container p0">
        <div class="box-white padding-lr-10 padding_tb_20">
            <p style="color:red;font-weight: bold ">
               @if (count($errors) > 0)
                    {{ trans('account.error_text_1') }}<br><br>
                    @foreach ($errors->all() as $error)
                        {{ trans('account.error_text_2') }}  {{ $error }} <br/>
                    @endforeach
               @endif
            </p>
            <p> {{ trans('account.reset_back_top') }} <a href="{{ url('/') }}"> {{ trans('account.active_text_3') }} </a>  </p>
        </div>
    </div>
</div>

<!-- End Main content -->
</div>
@endsection
