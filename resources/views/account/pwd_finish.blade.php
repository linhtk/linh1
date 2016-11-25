

@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
    @include('templates.header_not_search')
    <div class="main-content">
        <div class="container p0">
            <div class="box-white">
                <div class='signup-title'><span class="title-bor">{{ trans('account.reset_title') }}</span></div>
                <h4 class='text-center group-first'>{!! trans('account.Password changed') !!}</h4>

                <div class="row form-group txc div-btn-con group-first">
                    <a class="btn btn-white-00" href="{{url('/')}}" role="button">{{ trans('account.Close window') }}</a>
                </div>
            </div> <!-- ./container -->
        </div>
    </div>
</div>
@endsection