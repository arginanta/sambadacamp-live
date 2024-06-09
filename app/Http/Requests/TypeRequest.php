<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    //  Fungsi authorize() digunakan untuk memeriksa apakah pengguna yang mengirimkan form request telah melakukan otentikasi atau belum. Jika pengguna telah terotentikasi, maka request diperbolehkan untuk dijalankan. Jika tidak, maka request akan ditolak.
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
