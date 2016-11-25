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
                <span class="title-bor">{{ trans('account.Edit Bank Account') }}</span>
            </div>

            <div class="div-step row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-step">
                    <a class="name-step active" href="#">
                        <div class="step-num">1</div>
                        <div class="txt-step">{{ trans('account.step_1') }}</div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-step">
                    <a class="name-step" href="#">
                        <div class="step-num">2</div>
                        <div class="txt-step">{{ trans('account.step_2') }} </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-step">
                    <a class="name-step" href="#">
                        <div class="step-num">3</div>
                        <div class="txt-step">{{ trans('account.step_4') }}</div>
                    </a>
                </div>

            </div>

            <form method="POST" action="{{url('/account/edit_bank')}}" class="form-horizontal form-submit form-signup info-confirm" role="form" accept-charset="utf-8" autocomplete="off">
                {{csrf_field()}}

                @if (count($errors) > 0)
                    <br><br>
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="title-su-orange padding-lr-10">{{ trans('account.edit_bank_title') }}</div>
                <div class="form-more-info">
                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-3 col-xs-12">{{ trans('account.bank_account_name') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 div-input">
                            <input type="text" class="form-control input-signup" placeholder="{{ trans('account.bank_account_name') }}"
                                   id="bank_account_name" name="bank_account_name"
                                   value="{{ (old('bank_account_name', '') != '') ? old('bank_account_name','') : ( (isset($edit_bank['bank_account_name']) && trim($edit_bank['bank_account_name']) != '') ? trim($edit_bank['bank_account_name']) : '') }}" >
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-3 col-xs-12">{{ trans('account.bank_name') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 div-input">
                            <input type="text" placeholder="{{ trans('account.bank_name') }}" class="form-control input-signup"
                                   id="bank_name" name="bank_name"
                                   value="{{ (old('bank_name', '') != '') ? old('bank_name','') : ( (isset($edit_bank['bank_name']) && trim($edit_bank['bank_name']) != '') ? trim($edit_bank['bank_name']) : '') }}">

                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-3 col-xs-12">{{ trans('account.bank_branch_name') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 div-input">
                            <input type="text" placeholder="{{ trans('account.bank_branch_name') }}" class="form-control input-signup"
                                   id="bank_branch_name" name="bank_branch_name"
                                   value="{{ (old('bank_branch_name', '') != '') ? old('bank_branch_name','') : ( (isset($edit_bank['bank_branch_name']) && trim($edit_bank['bank_branch_name']) != '') ? trim($edit_bank['bank_branch_name']) : '')  }}" >

                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-3 col-xs-12">{{ trans('account.bank_account_number') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 div-input">
                            <input type="text" placeholder="{{ trans('account.bank_account_number') }}" class="form-control input-signup"
                                   id="bank_account_number" name="bank_account_number"
                                   value="{{ (old('bank_account_number', '') != '') ? old('bank_account_number','') : ( (isset($edit_bank['bank_account_number']) && trim($edit_bank['bank_account_number']) != '') ? trim($edit_bank['bank_account_number']) : '')  }}"  >
                        </div>
                    </div>
                </div>

                <div class="row form-group txc div-btn">
                    <a class="btn btn-white-00" href="{{url('account/mypage')}}">{{ trans('account.bank_back_mypage') }}</a>
                    <button type="submit" class="btn btn-orange">{{ trans('account.bank_submit_confirm') }}</button>
                </div>
            </form> <!-- /form -->
        </div>
    </div>
</div>

<!-- End Main content -->
</div>
@endsection