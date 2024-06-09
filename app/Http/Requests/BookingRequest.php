<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|numeric',
            'status' => 'required|string|max:255', // status booking
            'payment_method' => 'nullable|string', // metode pembayaran
            'payment_status' => 'required|string|max:255', // status pembayaran
            'payment_url' => 'nullable|string|max:255',
            'total_price' => 'nullable|numeric',
            // 'item_id' => 'required|exists:types,id',
            // 'user_id' => 'required|exists:users,id',
        ];
    }
}
