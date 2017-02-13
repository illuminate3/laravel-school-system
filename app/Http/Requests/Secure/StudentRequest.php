<?php namespace App\Http\Requests\Secure;

use App\Models\Student;
use App\Models\User;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'first_name' => 'required|min:3',
                    'last_name' => 'required|min:3',
                    'email' => 'required|email|unique:users,email',
                    'birth_date' => 'date_format:"' . Settings::get('date_format') . '"',
                    'address' => 'required',
                    'section_id' => 'required',
                    'order' => 'required|integer',
                    'password' => 'required|min:6',
                    'mobile' => 'min:5',
                    'phone' => 'required|min:5',
                    'gender' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                if (preg_match("/\/(\d+)$/", $this->url(), $mt))
                    $student = Student::find($mt[1]);
                return [
                    'first_name' => 'required|min:3',
                    'last_name' => 'required|min:3',
                    'email' => 'required|email|unique:users,email,' . (isset($student->user->id) ? $student->user->id : 0),
                    'birth_date' => 'date_format:"' . Settings::get('date_format') . '"',
                    'address' => 'required',
                    'section_id' => 'required',
                    'order' => 'required|integer',
                    'password' => 'min:6',
                    'mobile' => 'min:5',
                    'phone' => 'required|min:5',
                    'gender' => 'required',
                ];
            }
            default:
                break;
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

}
