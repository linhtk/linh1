<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:80',
            'email' => 'required|max:64|email|unique:users,email',
            'cmt_no' => 'required|numeric|digits_between:8,20',
            'cmt_date' => 'required|date|date_format:d-m-Y|before:' . date('Y-m-d', strtotime("+ 1 day")) . '',
            'cmt_local' =>'required|max:255',
            'address' =>'required|max:255',
            'tel' =>'required|numeric|digits_between:6,15',
            'passwd' =>'required|min:8|max:63',
            'retype_passwd' =>'required|min:8|max:63|same:passwd'
        ];
    }
}
