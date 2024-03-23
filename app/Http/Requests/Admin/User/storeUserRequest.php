<?php
namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class storeUserRequest extends FormRequest
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
            // 'nik' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',
            'type' => 'required',
        ];
    }

    public function messages()
    {
        return [
            // 'nik.required' => 'Deskripsi Tidak Boleh Kosong',    
        ];
    }
}
