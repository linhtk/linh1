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
                    <span class="title-bor">{{trans('toppage.Create account')}}</span>
                </div>

                <div class="div-step row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-step">
                        <a class="name-step active" href="#">
                            <div class="step-num">1</div>
                            <div class="txt-step">{{ trans('account.step_1') }} </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-step">
                        <a class="name-step" href="#">
                            <div class="step-num">2</div>
                            <div class="txt-step">{{ trans('account.step_2') }} </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-step">
                        <a class="name-step" href="#">
                            <div class="step-num">3</div>
                            <div class="txt-step">{{ trans('account.step_3') }}</div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-step">
                        <a class="name-step" href="#">
                            <div class="step-num">4</div>
                            <div class="txt-step">{{ trans('account.step_4') }}</div>
                        </a>
                    </div>

                </div>

                <form method="POST" id="form_register" class="form-horizontal form-signup" role="form" accept-charset="utf-8" autocomplete="off">
                    {{csrf_field()}}
                    <div class="title-su-orange">{{ trans('account.step_1') }}</div>

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
                                   value="{{ (isset($datas['name']) && trim($datas['name']) != '') ? trim($datas['name']) : old('name','') }}" autofocus />
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-2 col-xs-12">{{ trans('account.register_email') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 div-input">
                            <input class="form-control input-signup" type="email" placeholder="{{ trans('account.placeholder_register_email') }}"
                                   id="email" name="email" oninvalid="this.setCustomValidity('{{trans('account.please enter a email address')}}')" oninput="setCustomValidity('')"
                                   value="{{ (isset($datas['email']) && trim($datas['email']) != '') ? trim($datas['email']) : old('email','') }}">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-2 col-xs-12">{{ trans('account.register_cmnd_id') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 div-input">
                            <div class="row row-id">
                                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 input-id">
                                    <input class="form-control input-signup" type="text" placeholder="{{ trans('account.placeholder_register_cmnd_id') }}"
                                           id="cmt_no" name="cmt_no" autofocus
                                           value="{{ (isset($datas['cmt_no']) && trim($datas['cmt_no']) != '') ? trim($datas['cmt_no']) : old('cmt_no','') }}">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 input-id">
                                    <label class="label-control visible-xs col-xs-12 mt10">{{ trans('account.register_cmt_local') }}</label>
                                    <input type="text" class="form-control input-signup" placeholder="{{ trans('account.placeholder_register_cmt_local') }}"
                                           id="cmt_local" name="cmt_local" autofocus
                                           value="{{ (isset($datas['cmt_local']) && trim($datas['cmt_local']) != '') ? trim($datas['cmt_local']) : old('cmt_local','') }}">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 input-id">
                                    <label class="label-control visible-xs col-xs-12 mt10">{{ trans('account.register_cmt_date') }}</label>
                                    <div class='input-group date' id='datetimepicker9'>
                                        <input type="text" data-inputmask="'alias': 'dd-mm-yyyy'" placeholder="{{ trans('account.register_cmt_date') }}"
                                           id="cmt_date" name="cmt_date" readonly autofocus class="form-control input-signup"
                                           value="{{ (isset($datas['cmt_date']) && trim($datas['cmt_date']) != '') ? trim($datas['cmt_date']) : old('cmt_date','') }}" >
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
                                   value="{{ (isset($datas['address']) && trim($datas['address']) != '') ? trim($datas['address']) : old('address','') }}">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="label-control col-lg-3 col-md-3 col-sm-2 col-xs-12">{{ trans('account.register_phone') }}</label>
                        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 div-input">
                            <input type="tel" class="form-control input-signup"
                                   id="tel" name="tel" placeholder="{{ trans('account.placeholdern_register_phone') }}"
                                   value="{{ (isset($datas['tel']) && trim($datas['tel']) != '') ? trim($datas['tel']) : old('tel','') }}">

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

                    <div class="row form-group div-term mt5-mb">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input txt-term txc">
                            {!! trans('toppage.terms_of_service') !!}
                        </div>
                    </div>

                    <div class="row form-group txc div-btn-su">
                        <button type="button" id="btn_register" class="btn btn-orange">{{ trans('account.register_submit') }}</button>
                    </div>
                </form> <!-- /form -->


                <div aria-hidden="true" role="dialog" tabindex="-1" id="term-modal" class="modal fade bootstrap-dialog" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                               <div class="bootstrap-dialog-header"><div class="bootstrap-dialog-title"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> {{ trans('termofservice.term_of_service') }}</div></div>
                            </div>
                            <!--<form method="post" action="#"> -->
                            <div class="modal-body" style="padding-bottom: 0px;">
                                <div class="modal-body-content">
                                    {!! trans("termofservice.term_of_service_content") !!}
                                </div>
                            </div>
                            <div class="modal-footer"><a id="term_close" data-dismiss="modal"  class="btn btn-warning close close-popup" >{{ trans('termofservice.term_close') }}</a></div>
                            <!--</form>-->
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <script type="text/javascript">
                    $(document).ready(function() {

                        $("#datetimepicker9").datetimepicker({
                            format: 'DD-MM-YYYY',
                            ignoreReadonly: true,
                            maxDate: moment()
                        });
                        $("input#cmt_date").keypress(function(){
                            $("input#cmt_date").attr('readonly', true);
                        });

                       $('#btn_register').on("click",function(e){
                           e.preventDefault;
                           var passwd =  $('input#d_passwd').val();
                           var retype_passwd =  $('input#d_retype_passwd').val();
                           $('input#h_passwd').val(passwd);
                           $('input#h_retype_passwd').val(retype_passwd);
                           $('input#d_passwd').prop( "disabled", true );
                           $('input#d_retype_passwd').prop( "disabled", true );

                           $('#form_register').submit();
                       });

                    });
                </script>
            </div>
        </div>
    </div>

    <!-- End Main content -->
</div>
@endsection