<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelBookingRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
          return [
        'room_id' => 'required|exists:rooms,id',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
        'adults' => 'required|integer|min:1',
        'children' => 'required|integer|min:0',
        'infants' => 'required|integer|min:0',
    ];
    }
}
