@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
    @include('templates.header_not_search')
<?php
  $num_date = config('const.frontend_point_log_num_date');
?>
<!-- Main content -->
<div class="cbm-main-content">
    <div class="container p0">
        <div class="box-white box-white-first">
            <form method="GET" action="{{url('/account/point')}}" class="form-inline padding-lr-10 form-signup form_log" role="form" accept-charset="utf-8">
                {{csrf_field()}}
                <div class="signup-title"><span class='title-bor'>{{ trans('account.Point_History') }}</span></div>
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
                <div class="group-first txc">
                    <div class="form-group mg-bottom30 txl">
                        <label class='margin_right_5'>{{ trans('account.point_status') }}</label>
                        <select class="form-control margin_right_5 input_log_point" id="status" name="status">
                            <option  value="">      </option>
                            @if(!empty($arr_status))
                                @foreach($arr_status as $k=>$val)
                                    <?php
                                    $selected = '';
                                    $status = isset($data['status']) ? trim($data['status']) : '';
                                    if(is_numeric($status)) {
                                        $selected = ($status == $k) ? 'selected' : '';
                                    }
                                    ?>
                                    <option {{ $selected }} value="{{ $k }}">{{ $val }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group mg-bottom30 txl">
                        <label class='margin_right_5'>{{ trans('account.point_start_date') }}</label>
                        <div class='input-group date margin_right_5' id='datetimepicker_start_date'>
                            <input type="text" readonly data-inputmask="'alias': 'dd/mm/yyyy'" placeholder="{{   trans('account.point_placeholdern_start_date') }}"
                                id="start_date" name="start_date"  class="form-control width_date input_log_point"
                                value="{{ isset($data['start_date']) ? trim($data['start_date']) : date('d/m/Y',strtotime(" -$num_date day")) }}" >
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div> 
                    <div class="form-group mg-bottom30 txl">
                        <label class='margin_right_5'>{{ trans('account.point_end_date') }}</label>
                        <div class='input-group date margin_right_5' id='datetimepicker_end_date'>
                            <input type="text" readonly data-inputmask="'alias': 'dd/mm/yyyy'" placeholder="{{ trans('account.point_placeholdern_end_date') }}"
                                id="end_date" name="end_date"  class="form-control width_date input_log_point"
                                value="{{ isset($data['end_date']) ? trim($data['end_date']) : date('d/m/Y') }}" >
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="form-group mg-bottom30 txl">
                        <label class='margin_right_5'>{{ trans('account.point_adv_name') }}</label>
                        <input class="form-control adv_name margin_right_5 input_log_point" type="text" placeholder="{{trans('account.point_placeholdern_adv_name') }}"
                        id="adv_name" name="adv_name" value="{{ isset($data['adv_name']) ? trim($data['adv_name']) : '' }}"/>
                    </div>
                    <button type="submit" name="btn-search" class="btn btn_search_point mg-bottom30">{{ trans('account.point_search') }}</button>
                </div>
            </form> <!-- /form -->
        </div>
        <div class='box-white box-white-2'>
            <div id='list_log_point_user' class ="form-inline content_log_user_list">
                <div class='title-su-orange number_search border_bottom_none'>
                    <span>{{ trans('account.point_search_total_results') }} </span> {{ (count($arr_points) >0) ? $arr_points->total() : 0 }}
                </div>
                <ul id='list_log_user'>
                    <li class='col-lg-12 col-md-12 col-sm-12 col-xs-12 title hidden-xs'>
                        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-3'>{{ trans('account.point_col_action_date') }}</div>
                        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-3'>{{ trans('account.point_col_confirm_date') }}</div>
                        <div class='col-lg-5 col-md-5 col-sm-4 col-xs-3'>{{ trans('account.point_col_adv_name') }}</div>
                        <div class='col-lg-1 col-md-1 col-sm-2 col-xs-3'>{{ trans('account.point_col_point') }}</div>
                        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-3 txr'>{{ trans('account.point_col_status') }}</div>
                    </li>
                    @if (count($arr_points) >0 )
                        <?php $count = 0;?>
                        @foreach($arr_points as $key=>$values)
                            <?php
                                $count ++;
                                $page = isset($data['page']) ? intval($data['page']) : 1;
                                $count = ($page-1)*$num_page + $count;
                                $color = 'color_processing';
                                if($values->accept == 1 ) $color = 'color_done';
                                elseif( $values->accept == 2 ) $color = 'color_suspend';
                            ?>
                            <li class='col-lg-12 col-md-12 col-sm-12 col-xs-12 detait_log_list'>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-12 one'><span class='label_date_mb visible-xs-inline'>{{ trans('account.point_col_action_date') }}: </span>{{ $values->action_time != '' ? date('d/m/Y H:i:s',strtotime($values->action_time)) : '' }}</div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-12 tow'><span class='label_date_mb visible-xs-inline'>{{ trans('account.point_col_confirm_date') }}: </span>{{ $values->accept_time != '' ? date('d/m/Y H:i:s',strtotime($values->accept_time)) : '' }}</div>
                                <div class='col-lg-5 col-md-5 col-sm-4 col-xs-12 name_promation'>{{ isset($arr_promotions[$values->promotion_id]) ? $arr_promotions[$values->promotion_id] : '' }}</div>
                                <div class='col-lg-1 col-md-1 col-sm-2 col-xs-6 four {{$color}}'>{{ number_format(trim($values->price), 0,' ' , '.') }} <span class='hidden-lg hidden-md hidden-sm'>point</span></div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-6 five {{$color}} txr'>{{ isset($arr_status[$values->accept]) ? $arr_status[$values->accept] : '' }}</div>
                            </li>
                        @endforeach
                    @else
                        <li class='col-md-12 li_no_record'>{{ trans('account.point_result_no_record') }}</li>
                    @endif
                </ul>
                @if (count($arr_points) >0 ) 
                    <div class='row page-item pagination_user_log'><?php echo  $arr_points->appends(
                    [
                    'start_date' => isset($data['start_date']) ? $data['start_date'] : date('d/m/Y',strtotime(" -$num_date day")),
                    'end_date'=>isset($data['end_date']) ? $data['end_date'] : date('d/m/Y'),
                    'status'=>isset($data['status']) ? $data['status'] : '',
                    'adv_name'=>isset($data['adv_name']) ? $data['adv_name'] : ''
                    ])->links()  ?></div>
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
         $("#datetimepicker_start_date,#datetimepicker_end_date").datetimepicker({
            format: 'DD/MM/YYYY',
            ignoreReadonly: true,
            minDate: '<?php echo config('const.date_start_payment');?>',
            maxDate: moment()
        });
        $("input#start_date,input#end_date").keypress(function(){
            $("input#start_date,input#end_date").attr('readonly', true);
        });
    });
</script>
@endsection