<?php namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class ProfileChangeRequest extends Request
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
            'address' => 'required|min:3',
            'birth_city' => 'required|min:3',
            'image' => 'image|mimes:jpeg,jpg,bmp,png,gif|max:3000'
        ];
    }

}
