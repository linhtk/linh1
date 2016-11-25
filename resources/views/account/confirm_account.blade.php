@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
    @include('templates.header_not_search')
    <!-- Main content -->
    <div class="main-content">
        <div class="container p0">
            <div class="box-white">
                <div class="signup-title">
                    <span class="title-bor">{{ trans('account.Edit account') }}</span>
                </div>

                <div class="div-step row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-step">
                        <a class="name-step active done" href="{{url('/account/edit_account')}}">
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

                <form method="POST" action="{{url('/account/confirm_account')}}" class="form-horizontal form-signup info-confirm" role="form" accept-charset="utf-8">
                    {{csrf_field()}}
                    <div class="title-su-orange">{{ trans('account.step_2') }}</div>

                    @if (count($errors) > 0)
                        <br><br>
                        <div class="alert alert-danger">
                            <br><br>
                            {{ trans('account.confirm_msg_error') }}<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row form-group group-first">
                        <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_name') }}</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                            {{ $confirm_account['name'] }}
                            <input type="hidden"  id="name" name="name"  class="form-control" value="{{ $confirm_account['name'] }}" >
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_email') }}</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                            {{ $confirm_account['email'] }}
                            <input type="hidden"   id="email" name="email" class="form-control" value="{{ $confirm_account['email'] }}">
                        </div>
                    </div>

                    <div class="row form-group hidden-xs">
                        <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs">{{ trans('account.register_cmnd_id') }}</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-input">
                            <div class="row row-id" id='input_info_cmnd'>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 txt-id txt-id-pc txl">
                                    {{ $confirm_account['cmt_no'] }}
                                    <input type="hidden"   id="cmt_no" name="cmt_no"  class="form-control" value="{{ $confirm_account['cmt_no'] }}">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 txt-id border_rl">
                                    {{ $confirm_account['cmt_local'] }}
                                    <input type="hidden"   id="cmt_local" name="cmt_local"  class="form-control" value="{{ $confirm_account['cmt_local'] }}">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 txt-id">
                                    {{ $confirm_account['cmt_date'] }}
                                    <input type="hidden"   id="cmt_date" name="cmt_date"  class="form-control" value="{{ $confirm_account['cmt_date'] }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group hidden-lg hidden-md hidden-sm">
                        <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_cmnd_id') }}</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                            {{ $confirm_account['cmt_no'] }}
                        </div>
                    </div>
                    <div class="row form-group hidden-lg hidden-md hidden-sm">
                        <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_cmt_local') }}</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                            {{ $confirm_account['cmt_local'] }}
                        </div>
                    </div>
                    <div class="row form-group hidden-lg hidden-md hidden-sm">
                        <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_cmt_date') }}</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                            {{ $confirm_account['cmt_date'] }}
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_address') }}</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                            {{ $confirm_account['address'] }}
                            <input type="hidden"   id="address" name="address" value="{{ $confirm_account['address'] }}" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.register_phone') }}</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                            {{ $confirm_account['tel']}}
                            <input type="hidden" hidden="hidden"  id="tel"  name="tel" value="{{ $confirm_account['tel']}}"  class="form-control" >
                        </div>
                    </div>
                    @if (trim($confirm_account['passwd']) != '' &&  trim($confirm_account['retype_passwd']) != '')
                    <div class="row form-group">
                        <label class="label-control col-lg-2 col-md-2 col-sm-2 col-xs-12">{{ trans('account.login_password') }}</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 div-txt-conf">
                            *************
                            <input type="hidden"   id="passwd" name="passwd" value="{{ $confirm_account['passwd'] }}"  class="form-control" >
                            <input type="hidden"   id="retype_passwd" name="retype_passwd" value="{{ $confirm_account['retype_passwd'] }}"  class="form-control" >
                        </div>
                    </div>
                    @endif
                    <div class="row form-group txc div-btn">
                        <a href="{{url('/account/mypage')}}" class="btn btn-white-00"> {{ trans('account.back') }} </a>
                        <button type="submit" class="btn btn-orange">{{ trans('account.account_submit_confirm') }}</button>
                    </div>
                </form> <!-- /form -->
            </div>
        </div>
    </div>

    <!-- End Main content -->
</div>
@stop