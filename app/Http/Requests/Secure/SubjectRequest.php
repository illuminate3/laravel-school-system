<?php

namespace App\Http\Requests\Secure;

use App\Http\Requests\Request;

class SubjectRequest extends Request
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
            'title' => 'required|min:3',
            'direction_id' => 'required',
            'order' => 'integer|min:1',
            'class' => 'required|integer|min:1',
            'mark_system_id' => 'integer|min:1',
        ];
    }
}
