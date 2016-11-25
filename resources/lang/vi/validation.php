<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Xin đồng ý với  :attribute.',
    'active_url'           => ':attribute không phải là  một đường link hợp lệ.',
    'after'                => ':attribute phải là ngày sau ngày :date.',
    'alpha'                => 'Chỉ được nhập chữ cho mục :attribute.',
    'alpha_dash'           => 'Chỉ được nhập chữ, số và dấu gạch ngang cho  mục :attribute.',
    'alpha_num'           => 'Chỉ được nhập chữ, và số cho  mục :attribute.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute phải là ngày trước ngày :date.',
    'between'              => [
        'numeric' => ':attribute không được hỗ trợ',
        'file'    => ':attribute phải có giá trị từ :min đến :max kilobytes.',
        'string'  => ':attribute phải có giá trị từ :min and :max ký tự.',
        'array'   => ':attribute phải có giá trị từ :min and :max items.',
    ],
    'boolean'              => 'Trường :attribute phải là true hoặc false.',
    'confirmed'            => 'Phần xác nhận :attribute không trùng khớp.',
    'date'                 => ':attribute không phải là ngày hợp lệ.',
    'date_format'          => ':attribute chưa đúng định dạng :format.',
    'different'            => ':attribute phải khác với :other.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => ':attribute phải có từ :min đến :max chữ số.',
    'dimensions'           => 'Kích thước ảnh của :attribute không hợp lệ.',
    'distinct'             => 'Giá trị của mục :attribute đang bị trùng lặp.',
    'email'                => 'Hãy điền địa chỉ email hợp lệ vào mục :attribute.',
    'exists'               => ':attribute không tồn tại trong hệ thống.',
    'file'                 => 'Hãy chọn file cho mục :attribute.',
    'filled'               => 'Xin hãy nhập:attribute.',
    'image'                => 'Xin hãy upload ảnh cho :attribute .',
    'in'                   => 'Mục :attribute đã chọn không hợp lệ.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute phải là một số nguyên.',
    'ip'                   => ':attribute phải là 1 địa chỉ IP hợp lệ.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute không được phép lớn hơn :max.',
        'file'    => ':attribute không được phép lớn hơn :max kilobytes.',
        'string'  => ':attribute không được phép lớn hơn :max ký tự.',
        'array'   => ':attribute không được có nhiều hơn :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute không được nhỏ hơn :min.',
        'file'    => ':attribute không được nhỏ hơn :min kilobytes.',
        'string'  => ':attribute không được nhỏ hơn :min ký tự.',
        'array'   => ':attribute không được nhỏ hơn :min items.',
    ],
    'not_in'               => ':attribute được chọn không hợp lệ',
    'numeric'              => 'Xin nhập số cho :attribute .',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Định dạng của :attribute không hợp lệ.',
    'required'             => 'Xin hãy nhập :attribute.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute và :other phải trùng nhau.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute này đã tồn tại trong hệ thống.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',
    'captcha'              => 'Sai mã xác nhận',



    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
    'name' => 'Tên',
    'cmt_no' => 'Số chứng minh thư',
    'cmt_date' => 'Ngày cấp',
    'cmt_local' => 'Nơi cấp',
    'address' => 'Địa chỉ',
    'tel' => 'Số điện thoại',
    'passwd' => 'Mật khẩu',
    'retype_passwd' => 'Xác nhận mật khẩu',
    'bank_account_name' => 'Tên chủ tài khoản',
    'bank_name' => 'Tên ngân hàng',
    'bank_branch_name' => 'Chi nhánh',
    'bank_account_number' => 'Số tài khoản',
    'email' => 'Email',
    'start_date' => 'Ngày bắt đầu',
    'login_email' => 'Email',
    'login_passwd' => 'Mật khẩu',
    'contents' => 'Nội dung',
    'captcha' => 'Mã xác minh',
    'inquiry_type' => 'Vấn đề'
    ],

];
