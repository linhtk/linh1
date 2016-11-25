@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
    @include('templates.header_not_search')
<!-- Main content -->
<div class="cbm-main-content">
    <div class="container p0">
        <div class="box-white box-white-first">
            <form method="GET" action="{{url('/account/payment')}}" class="form-inline form-signup form_log padding-lr-10" role="form" accept-charset="utf-8">
                {{csrf_field()}}
                <div class="signup-title"><span class='title-bor'>{{ trans('account.Payment_History') }}</span></div>
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
                <div class='group-first txc'>
                    <div class="form-group mg-bottom10 txl">
                        <label for="exampleInputEmail2" class='margin_right_5'>{{ trans('account.payment_start_date') }}</label>
                        <div class='input-group date margin_right_40' id='datetimepicker_start_date'>
                            <input type="text" data-inputmask="'alias': 'dd/mm/yyyy'" placeholder="{{ trans('account.payment_placeholdern_start_date') }}"
                                id="start_date" name="start_date" readonly  class="form-control width_date input_log_point" value="{{ $start_date }}" >
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="form-group mg-bottom10 txl">
                        <label for="exampleInputName2" class='margin_right_5'>{{ trans('account.payment_end_date') }} </label>
                        <div class='input-group date margin_right_40' id='datetimepicker_end_date'>
                            <input type="text" data-inputmask="'alias': 'dd/mm/yyyy'" placeholder="{{ trans('account.payment_placeholdern_end_date') }}"
                                   id="end_date" readonly name="end_date"  class="form-control width_date input_log_point" value="{{ $end_date }}" >
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <button type="submit" name="btn-search" class="btn btn_search_point mg-bottom10">{{ trans('account.payment_search') }}</button>
                </div>
            </form> <!-- /form -->
        </div>
        <div class="box-white box-white-2">
            <div class ="form-inline content_log_user_list">
                <div class='title-su-orange number_search border_bottom_none'>
                    <span>{{ trans('account.payment_search_total_results') }} </span> {{ (count($arr_payments) >0) ? $arr_payments->total() : 0 }}
                </div>
                <ul id='list_log_user'>
                    <li class='col-lg-12 col-md-12 col-sm-12 col-xs-12 title hidden-xs'>
                        <div class='col-lg-5 col-md-5 col-sm-5 col-xs-4 one'>{{ trans('account.payment_col_month') }}</div>
                        <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4 two'>{{ trans('account.payment_col_amount') }}</div>
                        <div class='col-lg-3 col-md-3 col-sm-3 col-xs-4 three'>{{ trans('account.payment_col_status') }}</div>
                    </li>
                    @if (count($arr_payments) >0 )
                        <?php $count = 0;?>
                        @foreach($arr_payments as $key=>$values)
                            <?php
                                $count ++;
                                $page = ($page > 0) ? $page : 1;
                                $count = ($page-1)*$num_page + $count;
                                $month_year = \App\Helpers\Utils::format_month_year($values->month);
                                $color = 'color_processing';
                                if($values->payment_status == 1 ) $color = 'color_done';
                                elseif( $values->payment_status == 2 ) $color = 'color_suspend';
                            ?>
                            <li class='col-lg-12 col-md-12 col-sm-12 col-xs-12 detait_log_list'>
                                <div class='col-lg-5 col-md-5 col-sm-5 col-xs-6 one'>{{ $month_year }}</div>
                                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-12 two_pc_tb {{$color}} hidden-xs'>{{ number_format(trim($values->payment), 0,' ' , '.') }} VND</div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 three {{$color}}'>{{ isset($arr_status[$values->payment_status]) ? $arr_status[$values->payment_status] : '' }}</div>
                                <div class='col-lg-4 col-md-4 col-sm-4 col-xs-12 two_mb {{$color}} visible-xs'>{{ number_format(trim($values->payment), 0,' ' , '.') }} VND</div>
                            </li>
                        @endforeach
                    @else
                        <li class='col-md-12 li_no_record'>{{ trans('account.payment_result_no_record') }}</li>
                    @endif
                </ul>
                @if (count($arr_payments) >0 )
                    <div class='row page-item pagination_user_log'><?php echo  $arr_payments->appends(['start_date' => $start_date,'end_date'=>$end_date])->links()  ?></div>
                @endif
                <div class="row txc div-btn">
                    <a class="btn btn-white-00 btn-one-point" href="{{url('/account/mypage')}}">{{ trans('account.bank_back_mypage') }}</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<!-- End Main content -->
</div>
<script type="text/javascript">
    $(document).ready(function() {
	    var year_max = '<?php echo date('Y');?>';
	    var month_max = '<?php echo date('m');?>';
	    var maxDate =  new Date(year_max,month_max, +0); // max month current
	
	    var year_min = '<?php echo $arr_date_config["year"];?>';
	    var month_min = '<?php echo $arr_date_config["month"];?>' ;
	    var minDate =  new Date(year_min,month_min-1, 1);
	
	    $("#datetimepicker_start_date,#datetimepicker_end_date").datetimepicker({
	        viewMode: 'months',
	        format: 'MM/YYYY',
	        ignoreReadonly: true,
	        maxDate: maxDate,
	        minDate : minDate
	    });
	    $("input#start_date,input#end_date").keypress(function(){
	        $("input#start_date,input#end_date").attr('readonly', true);
	    });
    });
</script>
@endsection