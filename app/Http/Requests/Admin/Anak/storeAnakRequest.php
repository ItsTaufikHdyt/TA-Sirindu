<?php
namespace App\Http\Requests\Admin\Anak;

use Illuminate\Foundation\Http\FormRequest;

class storeAnakRequest extends FormRequest
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
            'nama' => 'required',
            'nama_ibu' => 'required',
            'nama_ayah' => 'required',
            'jk' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama Tidak Boleh Kosong',
            'nama_ibu.required' => 'Nama Ibu Tidak Boleh Kosong',
            'nama_ayah.required' => 'Nama Ayah Tidak Boleh Kosong',
            'jk.required' => 'Jenis Kelamin Tidak Boleh Kosong',
            'tempat_lahir.required' => 'Tempat Lahir Tidak Boleh Kosong',
            'tgl_lahir.required' => 'Tanggal Lahir Tidak Boleh Kosong',
        ];
    }
}
