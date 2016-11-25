@extends('templates.admin_layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('backend.Payment_History') }}</div>

                <div class="panel-body">
                <div class="panel-body">
                @if (isset($msg_permission))
                <span style="color: red">{{ $msg_permission }}</span>
                @else

                    <div class="col-md-12">
                        <div class="box">

                            <div class="box-body">
                                <div class="box-white">
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
                                    <div id="msg-status-save">

                                    </div>
                                <form method="GET" class="form-inline" role="form" accept-charset="utf-8">
                                  {{csrf_field()}}
                                    <div class="bd-box">
                                        <div class="form-group mg-bottom10">
                                            <label>{{ trans('backend.payment_start_date') }}</label>
                                            <div class='input-group date' id='datetimepicker_month'>
                                                <input type="text" data-inputmask="'alias': 'mm/yyyy'" placeholder="{{ trans('backend.payment_placeholdern_start_date') }}"
                                                       id="month" readonly name="month" autofocus class="form-control input-signup"
                                                       value="{{ isset($data['month']) ?trim($data['month']) : date('m/Y') }}" >
                                       <span class="input-group-addon">
                                           <span class="glyphicon glyphicon-calendar"></span>
                                       </span>
                                            </div>
                                        </div>

                                        <div class="form-group mg-bottom10">
                                            <label>{{ trans('backend.payment_user_id') }}</label>
                                            <input class="form-control" type="text" placeholder="{{ trans('backend.payment_placeholder_user_id') }}"
                                                   id="user_id" name="user_id" value="{{ isset($data['user_id']) ?trim($data['user_id']) : '' }}"  />
                                        </div>
                                        <div class="form-group mg-bottom10">
                                            <label>{{ trans('backend.payment_user_name') }}</label>
                                            <input class="form-control" type="text" placeholder="{{ trans('backend.payment_placeholder_user_name') }}"
                                                   id="name" name="name" value="{{ isset($data['name']) ?trim($data['name']) : '' }}"  />
                                        </div>
                                        <div class="form-group mg-bottom10">
                                            <label>{{ trans('backend.payment_email') }}</label>
                                            <input class="form-control" type="text" placeholder="{{ trans('backend.payment_placeholder_email') }}"
                                                   id="email" name="email" value="{{ isset($data['email']) ?trim($data['email']) : '' }}"  />
                                        </div>

                                        <div class="form-group mg-bottom10">
                                            <label>{{ trans('backend.payment_status') }}</label>
                                            <select class="form-control" id="status" name="status">
                                                <option  value="">      </option>
                                                @if(!empty($arr_status))
                                                    @foreach($arr_status as $k=>$val)
                                                        <?php
                                                        $selected = '';
                                                        $status = isset($data['status']) ?trim($data['status']) : '';
                                                        if (is_numeric($status)) {
                                                             $selected = ($status == $k) ? 'selected' : '';
                                                        }
                                                        ?>
                                                        <option {{ $selected }} value="{{ $k }}">{{ $val }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <button type="submit" name="btn-search" class="btn btn-primary mg-bottom10">{{ trans('backend.payment_search') }}</button>
                                    </div>

                            </form>
                            </div>
                            <div class="clearfix"></div>
                            <div class ="top-buffer">
                            <form  id="paymentSubmit" method="POST" class="form-inline" role="form" accept-charset="utf-8">
                                <button type="submit" id="save-all" name="save-all" class="btn btn-info right">{{ trans('backend.point_save_all') }}</button>
                            <div class="clearfix"></div>
                             <div style="padding: 5px 0 ;">
                                <span>{{ trans('account.payment_search_total_results') }} </span> {{ (count($arr_payments) >0) ? $arr_payments->total() : 0 }}
                            </div>
                            <table class="col-md-12 table-bordered table-striped table-condensed cf">
                              <thead class="thead-inverse">
                                <tr>
                                  <th>#</th>
                                    <th>UserID</th>
                                  <th>{{ trans('backend.payment_col_user_name') }}</th>
                                  <th>{{ trans('backend.payment_col_user_email') }}</th>
                                  <th>{{ trans('backend.payment_col_bank_name') }}</th>
                                  <th>{{ trans('backend.payment_col_bank_branch') }}</th>
                                  <th>{{ trans('backend.payment_col_account_number') }}</th>
                                  <th>{{ trans('backend.payment_col_amount') }}</th>
                                  <th style="display: none;">{{ trans('backend.payment_col_payment_time') }}</th>
                                  <th>{{ trans('backend.payment_col_status') }}</th>
                                </tr>
                              </thead>
                              <tbody>
                              @if (count($arr_payments) >0 )
                              <?php
                               $i = 1;
                              ?>
                              @foreach($arr_payments as $key=>$values)
                              <?php
                                $page = ($page > 0) ? $page : 1;
                                $count = ($page-1)*$num_page + $i;
                              ?>
                                <tr>
                                 <td scope="row">{{ $count }}</td>
                                 <td>{{ $values->user_id }}</td>
                                 <td>{{ $values->name }}</td>
                                 <td>{{ $values->email }}</td>
                                 <td>{{ $values->bank_name }}</td>
                                 <td>{{ $values->bank_branch_name }}</td>
                                 <td>{{ $values->bank_account_number }}</td>
                                 <td>{{ number_format(trim($values->payment), 0,' ' , '.') }}</td>
                                 <td style="display: none;" id="col_payment_time_{{$values->p_id}}">{{$values->payment_time}}</td>
                                 <td id="col_payment_status_{{$values->p_id}}">
                                 @if(isset($values->p_status) && $values->p_status == 0)
                                 @if(!empty($arr_status))
                                     <select class="form-control" id="{{$values->p_id}}" name="status_payment_{{$values->p_id}}">
                                        @foreach($arr_status as $k=>$val)
                                         <option  value="{{ $k }}">{{ $val }}</option>
                                         @endforeach
                                     </select>
                                    @endif
                                 @elseif(isset($values->p_status) && $values->p_status == 1)
                                     @if(!empty($arr_status))
                                         <?php
                                             $arr = $arr_status;
                                             unset($arr[0]);
                                         ?>
                                         <select class="form-control" id="{{$values->p_id}}" name="status_payment_{{$values->p_id}}">
                                             @foreach($arr as $k=>$val)
                                                 <option  value="{{ $k }}">{{ $val }}</option>
                                             @endforeach
                                         </select>
                                     @endif
                                 @else
                                 <span>{{ isset($arr_status[$values->p_status]) ? $arr_status[$values->p_status] : '' }}</span>
                                 @endif

                                 </td>

                                </tr>
                                <?php $i++;?>
                                @endforeach
                               @else
                                 <tr>
                                  <td colspan="9">{{ trans('backend.payment_result_no_record') }}</td>
                                 </tr>
                               @endif

                              </tbody>
                            </table>
                            <div class="clearfix"></div>
                            @if (count($arr_payments) >0 )
                            <div class="pagination"><?php echo ($status != '') ? $arr_payments->appends(['month' => $month,'status'=>$status])->links() : $arr_payments->appends(['month' => $month])->links(); ?></div>
                            @endif
                            </div>
                        </div>
                    </div>
                    </div>

                @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
     $(function() {
         var year_max = '<?php echo date('Y');?>';
         var month_max = '<?php echo date('m');?>';
         var maxDate =  new Date(year_max,month_max, +0); // max month current
         var year_min = '<?php echo $arr_date_config["year"];?>';
        var month_min = '<?php echo $arr_date_config["month"];?>' ;
        var minDate =  new Date(year_min,month_min-1, 1);
        $("#datetimepicker_month").datetimepicker({
            viewMode: 'months',
            format: 'MM/YYYY',
            ignoreReadonly: true,
            maxDate: maxDate,
            minDate : minDate
        });
         $("input#month").keypress(function(){
             $("input#month").attr('readonly', true);
         });
    });

     $(document).ready(function() {
         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });
         //Save all
         $('#save-all').click(function(ev) {
             var commentContainer = $(this).parent().parent();
             //var href = $(this).attr('href');
             var ids = $(this).attr("id");
             if (!$('#dataConfirmModal').length) {
                 $('body').append('<div id="dataConfirmModal" class="modal fade bootstrap-dialog type-primary size-normal in" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><div class="bootstrap-dialog-header"><div class="bootstrap-dialog-title"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>{{ trans("backend.payment_popup_save_title") }}</div></div></div><div class="modal-body">{{ trans("backend.payment_popup_save_content") }}</div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">{{ trans("backend.payment_popup_save_cancel") }}</button><a class="btn btn-primary dataConfirmOK" id="'+ids+'">{{ trans("backend.payment_popup_save_ok") }}</a></div></div></div></div>');
             }
             $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
             //$('#dataConfirmOK').attr('href', href);
             $('#dataConfirmModal').modal({show:true});
             //start ajax
             $('.dataConfirmOK').click(function() {
                 $('#dataConfirmModal').remove();
                 $('.modal-backdrop').remove();
                 $.ajax({
                     type: "POST",
                     url: "/admin/save_all_payment",
                     data: {datas: $("#paymentSubmit").serialize()},
                     cache: false,
                     success: function(response){
                         var json_obj = jQuery.parseJSON(response);
                         var status = json_obj.status;
                         var msg = json_obj.msg;
                         if (status == 2) {
                            var login_url = '{{ url('/admin/login') }}'
                            window.location.href = login_url;
                          }else if (status == 1) {
                            var success = json_obj.success;
                             $('#msg-status-save').html(msg);
                             $('#msg-status-save').show();
                             $.each(success, function (id, value) {
                                 $('td#col_payment_time_'+id).html('');
                                 $('td#col_payment_time_'+id).html(value.payment_time);
                                 $('td#col_payment_status_'+id).html('');
                                 $('td#col_payment_status_'+id).html(value.payment_status);
                             });
                             setTimeout(function() {
                                 $("#msg-status-save").fadeOut();
                             }, 5000);

                         } else {
                              $('#msg-status-save').html(msg);
                              $('#msg-status-save').show();

                              setTimeout(function() {
                                  $("#msg-status-save").fadeOut();
                              }, 5000);
                         }
                         $('html, body').css('overflowY', 'auto');
                     }

                 });

                 return false;
             });
             //end ajax
             return false;
         });
     });
</script>
@endsection
