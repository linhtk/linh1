@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
    @include('templates.header_not_search')
<!-- Main content -->

<div class="cbm-main-content">
    <div class="container p0">
        <div class="box-white">
            <div class="signup-title">
                <span class="title-bor">{{ trans('account.Edit account') }}</span>
            </div>

            <div class="div-step row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-step">
                    <a class="name-step active done" href="#">
                        <div class="step-num">1</div>
                        <div class="txt-step">{{ trans('account.step_1') }}</div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-step">
                    <a class="name-step active done" href="#">
                        <div class="step-num">2</div>
                        <div class="txt-step">{{ trans('account.step_2') }} </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-step">
                    <a class="name-step active done" href="#">
                        <div class="step-num">3</div>
                        <div class="txt-step">{{ trans('account.step_4') }}</div>
                    </a>
                </div>

            </div>

            <div class="form-horizontal form-submit form-signup info-confirm">
                <div class="title-su-orange">{{ trans('account.Succeed on user edition') }}</div>

                <div class="row form-group group-first">
                    <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_name') }}</label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                        {{ $finish_account['name'] }}
                    </div>
                </div>

                <div class="row form-group">
                    <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_email') }}</label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                        {{ $finish_account['email'] }}
                    </div>
                </div>

                <div class="row form-group hidden-xs">
                    <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12 hidden-xs">{{ trans('account.register_cmnd_id') }}</label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-input">
                        <div class="row row-id" id='input_info_cmnd'>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 txt-id txt-id-pc txl">
                                {{ $finish_account['cmt_no'] }}
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 txt-id border_rl">
                                {{ $finish_account['cmt_local'] }}
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 txt-id">
                                {{ $finish_account['cmt_date'] }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row form-group hidden-lg hidden-md hidden-sm">
                    <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_cmnd_id') }}</label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                        {{ $finish_account['cmt_no'] }}
                    </div>
                </div>
                <div class="row form-group hidden-lg hidden-md hidden-sm">
                    <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_cmt_local') }}</label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                        {{ $finish_account['cmt_local'] }}
                    </div>
                </div>
                <div class="row form-group hidden-lg hidden-md hidden-sm">
                    <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_cmt_date') }}</label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                        {{ $finish_account['cmt_date'] }}
                    </div>
                </div>

                <div class="row form-group">
                    <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_address') }}</label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                        {{ $finish_account['address'] }}
                    </div>
                </div>

                <div class="row form-group">
                    <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_phone') }}</label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                        {{ $finish_account['tel']}}
                    </div>
                </div>

                <div class="row form-group txc div-btn">
                    <a class="btn btn-white-00" href="{{url('/account/mypage')}}">{{ trans('account.bank_back_mypage') }}</a>
                </div>
            </div> <!-- /form -->
        </div>
    </div>
</div>

<!-- End Main content -->
</div>
@endsection