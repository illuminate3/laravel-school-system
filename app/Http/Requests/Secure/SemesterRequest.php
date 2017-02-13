<?php

namespace App\Http\Requests\Secure;

use App\Http\Requests\Request;
use Efriandika\LaravelSettings\Facades\Settings;

class SemesterRequest extends Request
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
            'school_year_id' => 'required',
            'start' => 'required|date_format:"' . Settings::get('date_format') . '"',
            'end' => 'required|date_format:"' . Settings::get('date_format') . '"',
        ];
    }
}
