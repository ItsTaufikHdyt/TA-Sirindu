<?php
namespace App\Http\Requests\Admin\Anak;

use Illuminate\Foundation\Http\FormRequest;

class updateAnakRequest extends FormRequest
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
            'no_kk' => 'required',
            'nik' => 'required',
            'nama' => 'required',
            'nik_ortu' => 'required',
            'nama_ibu' => 'required',
            'nama_ayah' => 'required',
            'jk' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'golda' => 'required',
            'anak' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'no_kk.required' => 'No KK Tidak Boleh Kosong',
            'nik.required' => 'NIK Tidak Boleh Kosong',
            'nama.required' => 'Nama Tidak Boleh Kosong',
            'nik_ortu.required' => 'NIK Orang Tua Tidak Boleh Kosong',
            'nama_ibu.required' => 'Nama Ibu Tidak Boleh Kosong',
            'nama_ayah.required' => 'Nama Ayah Tidak Boleh Kosong',
            'jk.required' => 'Jenis Kelamin Tidak Boleh Kosong',
            'tempat_lahir.required' => 'Tempat Lahir Tidak Boleh Kosong',
            'tgl_lahir.required' => 'Tanggal Lahir Tidak Boleh Kosong',
            'golda.required' => 'Golongan Darah Tidak Boleh Kosong',
            'anak.required' => 'Anak Ke Tidak Boleh Kosong',
        ];
    }
}
