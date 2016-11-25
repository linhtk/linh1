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
                    <a class="name-step active done" href="{{url('/account/edit_bank')}}">
                        <div class="step-num">1</div>
                        <div class="txt-step">{{ trans('account.step_1') }}</div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-step">
                    <a class="name-step active" href="#">
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

            <form method="POST" action="{{url('/account/confirm_bank')}}" class="form-horizontal form-signup info-confirm" role="form" accept-charset="utf-8">
                {{csrf_field()}}
                <div class="title-su-orange mb15">{{ trans('account.confirm_title') }}</div>

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

                <div class="row form-group">
                    <label class="label-control col-lg-3 col-md-3 col-sm-3 col-xs-12">{{ trans('account.bank_account_name') }}</label>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 div-txt-conf">
                        {{ $confirm_bank['bank_account_name'] }}
                        <input type="hidden"  id="bank_account_name" name="bank_account_name"  value="{{ $confirm_bank['bank_account_name'] }}" >
                    </div>
                </div>

                <div class="row form-group">
                    <label class="label-control col-lg-3 col-md-3 col-sm-3 col-xs-12">{{ trans('account.bank_name') }}</label>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 div-txt-conf">
                        {{ $confirm_bank['bank_name'] }}
                        <input type="hidden"   id="bank_name" name="bank_name" value="{{ $confirm_bank['bank_name'] }}">
                    </div>
                </div>

                <div class="row form-group">
                    <label class="label-control col-lg-3 col-md-3 col-sm-3 col-xs-12">{{ trans('account.bank_branch_name') }}</label>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 div-txt-conf">
                        {{ $confirm_bank['bank_branch_name'] }}
                        <input type="hidden"   id="bank_branch_name" name="bank_branch_name" value="{{ $confirm_bank['bank_branch_name'] }}">
                    </div>
                </div>

                <div class="row form-group">
                    <label class="label-control col-lg-3 col-md-3 col-sm-3 col-xs-12">{{ trans('account.bank_account_number') }}</label>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 div-txt-conf">
                        {{ $confirm_bank['bank_account_number']}}
                        <input type="hidden" id="bank_account_number"  name="bank_account_number" value="{{ $confirm_bank['bank_account_number']}}">
                    </div>
                </div>

                <div class="row form-group txc div-btn">
                    <a class="btn btn-white-00" href="{{url('account/edit_bank')}}">{{ trans('account.back') }}</a>
                    <button type="submit" class="btn btn-orange">{{ trans('account.confirm_title') }}</button>
                </div>

            </form> <!-- /form -->
        </div>
    </div>
</div>

<!-- End Main content -->
</div>
@endsection