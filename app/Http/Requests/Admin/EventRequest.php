<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Asegúrate de que solo los usuarios autorizados puedan enviar este formulario
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      return [
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'date' => 'required|date',
        'time' => 'required',
      ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
      return [
        'name.required' => 'El título del evento es obligatorio',
        'address.required' => 'La dirección es obligatoria',
        'price.required' => 'El precio es obligatorio',
        'date.required' => 'La fecha del evento es obligatoria',
        'time.required' => 'La hora del evento es obligatoria',
      ];
    }
}