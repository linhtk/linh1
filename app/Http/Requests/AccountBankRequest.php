<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountBankRequest extends FormRequest
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
            'bank_account_name' => 'required|max:255',
            'bank_name' => 'required|max:255',
            'bank_branch_name' => 'required|max:255',
            'bank_account_number' => 'required|numeric|digits_between:6,30',
        ];
    }
}
