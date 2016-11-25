@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
    @include('templates.header_not_search')
    <div class="main-content">
        <div class="container p0">
            @include('templates.sidebar')
            <div class='col-lg-9 col-md-9 col-sm-12 col-xs-12 categories-right'>
                <div class="box-white">
                    <div class='signup-title'> <span class="title-bor">{{ trans('account.user_page') }}</span></div>
                    <div id='icon_user_page' class='group-first'>
                        <div class="form-group div-btn icon_user_page border_left_iup">
                            <a class="btn icon_user_edit" href="{{url('/account/edit_account')}}" role="button">{{ trans('account.mypage_edit_account_btn') }}</a>
                        </div>
                        <div class="form-group div-btn icon_user_page">
                            <a class="btn icon_save" href="{{url('/account/edit_bank')}}" role="button">{{ trans('account.mypage_edit_bank_btn') }}</a>
                        </div>
                        <div class="form-group div-btn icon_user_page border_left_iup">
                            <a class="btn icon_report" href="{{url('/account/payment')}}" role="button">{{ trans('account.see_incentive_report') }}</a>
                        </div>
                        <div class="form-group div-btn icon_user_page border_left_iup border_right_none">
                            <a class="btn icon_report" href="{{url('/account/point')}}" role="button">{{ trans('account.mypage_menu_point_log') }}</a>
                        </div>
                    </div>
                </div> 
            </div>
        </div><!-- ./container -->
    </div>
</div>
@endsection