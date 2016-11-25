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
                <span class="title-bor">{{ trans('account.edit_bank_title') }}</span>
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
                <div class="title-su-orange">{{ trans('account.bank_finish_title') }}</div>

                <div class="row form-group group-first">
                    <label class="label-control col-lg-3 col-md-3 col-sm-3 col-xs-12">{{ trans('account.bank_account_name') }}</label>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 div-txt-conf">
                        {{ $finish_bank['bank_account_name'] }}
                    </div>
                </div>

                <div class="row form-group">
                    <label class="label-control col-lg-3 col-md-3 col-sm-3 col-xs-12">{{ trans('account.bank_name') }}</label>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 div-txt-conf">
                        {{ $finish_bank['bank_name'] }}
                    </div>
                </div>

                <div class="row form-group">
                    <label class="label-control col-lg-3 col-md-3 col-sm-3 col-xs-12">{{ trans('account.bank_branch_name') }}</label>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 div-txt-conf">
                        {{ $finish_bank['bank_branch_name'] }}
                    </div>
                </div>

                <div class="row form-group">
                    <label class="label-control col-lg-3 col-md-3 col-sm-3 col-xs-12">{{ trans('account.bank_account_number') }}</label>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 div-txt-conf">
                        {{ $finish_bank['bank_account_number']}}
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