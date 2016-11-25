            <form method="POST" action="{{url('/account/edit_bank')}}" class="form-horizontal" role="form" accept-charset="utf-8">
            {{csrf_field()}}

                @if (count($errors) > 0)
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">{{ trans('account.bank_account_name') }}</label>
                    <div class="col-sm-9">
                        <input type="text" id="bank_account_name" name="bank_account_name" placeholder="{{ trans('account.bank_account_name') }}" class="form-control" value="{{ (old('bank_account_name', '') != '') ? old('bank_account_name','') : ( (isset($edit_bank['bank_account_name']) && trim($edit_bank['bank_account_name']) != '') ? trim($edit_bank['bank_account_name']) : '') }}" >

                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">{{ trans('account.bank_name') }}</label>
                    <div class="col-sm-9">
                        <input type="text" id="bank_name" name="bank_name" placeholder="{{ trans('account.bank_name') }}" class="form-control" value="{{ (old('bank_name', '') != '') ? old('bank_name','') : ( (isset($edit_bank['bank_name']) && trim($edit_bank['bank_name']) != '') ? trim($edit_bank['bank_name']) : '') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="col-sm-3 control-label">{{ trans('account.bank_branch_name') }}</label>
                    <div class="col-sm-9">
                        <input type="text" id="bank_branch_name" name="bank_branch_name" value="{{ (old('bank_branch_name', '') != '') ? old('bank_branch_name','') : ( (isset($edit_bank['bank_branch_name']) && trim($edit_bank['bank_branch_name']) != '') ? trim($edit_bank['bank_branch_name']) : '') }}" placeholder="{{ trans('account.bank_branch_name') }}" class="form-control" >

                    </div>
                </div>
                <div class="form-group">
                    <label for="tel" class="col-sm-3 control-label">{{ trans('account.bank_account_number') }}</label>
                    <div class="col-sm-9">
                        <input type="text" id="bank_account_number" name="bank_account_number" value="{{ (old('bank_account_number', '') != '') ? old('bank_account_number','') : ( (isset($edit_bank['bank_account_number']) && trim($edit_bank['bank_account_number']) != '') ? trim($edit_bank['bank_account_number']) : '')  }}" placeholder="{{ trans('account.bank_account_number') }}" class="form-control" >

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button type="submit" class="btn btn-primary btn-success">{{ trans('account.bank_submit_edit') }}</button>
                    </div>
                </div>

            </form> <!-- /form -->


