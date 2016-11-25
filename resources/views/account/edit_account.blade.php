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
                        <a class="name-step active" href="#">
                            <div class="step-num">1</div>
                            <div class="txt-step">{{ trans('account.step_1') }} </div>
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

                <form method="POST" id="form_edit_account" action="{{url('/account/edit_account')}}" class="form-horizontal form-signup " role="form" accept-charset="utf-8" autocomplete="off">
                    {{csrf_field()}}
                    <div class="title-su-orange">{{ trans('account.edit_title') }}</div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row form-group group-first mt10-mb">
                        <label class="label-control col-lg-3 col-md-3 col-sm-2 col-xs-12">{{ trans('account.register_name') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 div-input">
                            <input class="form-control input-signup" type="text" placeholder="{{ trans('account.placeholder_register_name') }}"
                                   id="name" name="name"
                                   value="{{ (old('name', '') != '') ? old('name','') : ( (isset($edit_account['name']) && trim($edit_account['name']) != '') ? trim($edit_account['name']) : '')  }}" autofocus />
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-2 col-xs-12">{{ trans('account.register_email') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 div-input mt15">
                            {{ (isset($edit_account['email']) && trim($edit_account['email']) != '') ? trim($edit_account['email']) : old('email','') }}
                            <input type="hidden" class="form-control"
                                   id="email" name="email"
                                   value="{{ (isset($edit_account['email']) && trim($edit_account['email']) != '') ? trim($edit_account['email']) : old('email','') }}">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-2 col-xs-12">{{ trans('account.register_cmnd_id') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 div-input">
                            <div class="row row-id">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 input-id">
                                    <input class="form-control input-signup" type="text" placeholder="{{ trans('account.placeholder_register_cmnd_id') }}"
                                           id="cmt_no" name="cmt_no" autofocus
                                           value="{{ (old('cmt_no', '') != '') ? old('cmt_no','') : ( (isset($edit_account['cmt_no']) && trim($edit_account['cmt_no']) != '') ? trim($edit_account['cmt_no']) : '') }}">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 input-id">
                                    <label class="label-control visible-xs col-xs-12 mt10">{{ trans('account.register_cmt_local') }}</label>
                                    <input type="text" class="form-control input-signup" placeholder="{{ trans('account.placeholder_register_cmt_local') }}"
                                           id="cmt_local" name="cmt_local" autofocus
                                           value="{{ (old('cmt_local', '') != '') ? old('cmt_local','') : ( (isset($edit_account['cmt_local']) && trim($edit_account['cmt_local']) != '') ? trim($edit_account['cmt_local']) : '') }}">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 input-id">
                                    <label class="label-control visible-xs col-xs-12 mt10">{{ trans('account.register_cmt_date') }}</label>
                                    <div class='input-group date' id='datetimepicker9'>
                                        <input type="text" data-inputmask="'alias': 'dd-mm-yyyy'" placeholder="{{ trans('account.register_cmt_date') }}"
                                           id="cmt_date" name="cmt_date" autofocus class="form-control input-signup"
                                           value="{{ (old('cmt_date', '') != '') ? old('cmt_date','') : ( (isset($edit_account['cmt_date']) && trim($edit_account['cmt_date']) != '') ? trim(date('d-m-Y',strtotime($edit_account['cmt_date']))) : '') }}" >
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-2 col-xs-12">{{ trans('account.register_address') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 div-input">
                            <input type="text" class="form-control input-signup" placeholder="{{ trans('account.placeholder_register_address') }}"
                                   id="address" name="address" autofocus
                                   value="{{ (old('address', '') != '') ? old('address','') : ( (isset($edit_account['address']) && trim($edit_account['address']) != '') ? trim($edit_account['address']) : '') }}">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-2 col-xs-12">{{ trans('account.register_phone') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 div-input">
                            <input type="text" class="form-control input-signup"
                                   id="tel" name="tel" placeholder="{{ trans('account.placeholdern_register_phone') }}" autofocus
                                   value="{{ (old('tel', '') != '') ? old('tel','') : ( (isset($edit_account['tel']) && trim($edit_account['tel']) != '') ? trim($edit_account['tel']) : '') }}">

                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-2 col-xs-12">{{ trans('account.login_password') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 div-input">
                            <input type="password" class="form-control input-signup" placeholder="{{ trans('account.placeholdern_register_password') }}"
                                   id="d_passwd" name="d_passwd"
                                   value=""  >
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-2 col-xs-12">{{ trans('account.register_password_retype') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 div-input">
                            <input type="password" class="form-control input-signup" placeholder="{{ trans('account.placeholder_password_retype') }}"
                                   id="d_retype_passwd" name="d_retype_passwd"
                                   value="">
                        </div>
                    </div>
                     <input type="hidden" class="form-control input-signup" id="h_passwd" name="passwd" value=""  >
                     <input type="hidden" class="form-control input-signup" id="h_retype_passwd" name="retype_passwd" value=""  >

                    <div class="row form-group txc div-btn">
                        <a class="btn btn-white-00" href="{{url('/account/mypage')}}">{{ trans('account.bank_back_mypage') }}</a>
                        <button type="button" id="btn_edit_account" class="btn btn-orange">{{ trans('account.account_submit_edit') }}</button>
                    </div>
                </form> <!-- /form -->
                <script type="text/javascript">
                    $(document).ready(function() {

                        $("#datetimepicker9").datetimepicker({
                            format: 'DD-MM-YYYY'
                        });
                        $('#btn_edit_account').on("click",function(e){
                           e.preventDefault;
                           var passwd =  $('input#d_passwd').val();
                           var retype_passwd =  $('input#d_retype_passwd').val();
                           $('input#h_passwd').val(passwd);
                           $('input#h_retype_passwd').val(retype_passwd);
                           $('input#d_passwd').prop( "disabled", true );
                           $('input#d_retype_passwd').prop( "disabled", true );

                           $('#form_edit_account').submit();
                        });

                    });
                </script>
            </div>
        </div>
    </div>
</div>
<!-- End Main content -->
@stop