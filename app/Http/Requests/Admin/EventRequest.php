<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

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
        'address' => 'string|max:255',
        'price' => 'required|numeric|min:0',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after_or_equal:start_time',
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
        'name.string' => 'El título del evento debe ser una cadena de texto',
        'name.max' => 'El título del evento no puede contener más de 255 caracteres',
        'address.string' => 'La dirección del evento debe ser una cadena de texto',
        'address.max' => 'La dirección del evento no puede contener más de 255 caracteres',
        'price.required' => 'El precio del evento es obligatorio',
        'price.numeric' => 'El precio del evento debe ser un número',
        'price.min' => 'El precio del evento no puede ser menor que 0',
        'start_date.required' => 'La fecha de inicio del evento es obligatoria',
        'start_date.date' => 'La fecha de inicio del evento debe ser una fecha',
        'end_date.required' => 'La fecha de fin del evento es obligatoria',
        'end_date.date' => 'La fecha de fin del evento debe ser una fecha',
        'end_date.after_or_equal' => 'La fecha de fin del evento debe ser posterior o igual a la fecha de inicio',
        'start_time.required' => 'La hora de inicio del evento es obligatoria',
        'start_time.date_format' => 'La hora de inicio del evento debe ser una hora',
        'end_time.required' => 'La hora de fin del evento es obligatoria',
        'end_time.date_format' => 'La hora de fin del evento debe ser una hora',
        'end_time.after' => 'La hora de fin del evento debe ser posterior a la hora de inicio',
      ];
    }

    public function withValidator($validator)
    {
      $validator->after(function ($validator) {
        $start_date = $this->input('start_date');
        $end_date = $this->input('end_date');
        $start_time = $this->input('start_time');
        $end_time = $this->input('end_time');

        $start_dateTime = Carbon::createFromFormat('Y-m-d H:i', $start_date . ' ' . $start_time);
        $end_dateTime = Carbon::createFromFormat('Y-m-d H:i', $end_date . ' ' . $end_time);

        if ($end_dateTime->lessThan($start_dateTime)) {
            $validator->errors()->add('end_time', 'El tiempo de finalización debe ser después del tiempo de inicio.');
        }
      });
    }
}