@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
    @include('templates.header_not_search')

	 <div class="main-content">
        <div class="container p0">
            <div class="box-white">
                <div class='form-signup'>
                    <div class="signup-title">
                        <span class="title-bor">{{ trans('account.reset_title') }}</span>
                    </div>
                    <h4 class='txc title_msg'>{!! trans('account.pwd_active_text_1') !!}</h4>
                    <div class="row form-group txc div-btn group-first">
                        <a class="btn btn-white-00" href="{{url('/')}}" role="button">{{ trans('account.reset_back_top') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ./container -->
</div>
@endsection