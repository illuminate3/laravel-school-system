<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\User;

class VerifyRequest extends Request
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
            'envato_username' => 'required',
            'envato_email' => 'email',
            'purchase_code' => 'required|size:36',
        ];
    }
}
