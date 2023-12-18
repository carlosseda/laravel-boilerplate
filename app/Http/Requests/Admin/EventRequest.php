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
        'startDate' => 'required|date',
        'endDate' => 'required|date|after_or_equal:startDate',
        'startTime' => 'required|date_format:H:i',
        'endTime' => 'required|date_format:H:i|after_or_equal:startTime',
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
        'startDate.required' => 'La fecha de inicio del evento es obligatoria',
        'startDate.date' => 'La fecha de inicio del evento debe ser una fecha',
        'endDate.required' => 'La fecha de fin del evento es obligatoria',
        'endDate.date' => 'La fecha de fin del evento debe ser una fecha',
        'endDate.after_or_equal' => 'La fecha de fin del evento debe ser posterior o igual a la fecha de inicio',
        'startTime.required' => 'La hora de inicio del evento es obligatoria',
        'startTime.date_format' => 'La hora de inicio del evento debe ser una hora',
        'endTime.required' => 'La hora de fin del evento es obligatoria',
        'endTime.date_format' => 'La hora de fin del evento debe ser una hora',
        'endTime.after' => 'La hora de fin del evento debe ser posterior a la hora de inicio',
      ];
    }

    public function withValidator($validator)
    {
      $validator->after(function ($validator) {
        $startDate = $this->input('startDate');
        $endDate = $this->input('endDate');
        $startTime = $this->input('startTime');
        $endTime = $this->input('endTime');

        $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $startDate . ' ' . $startTime);
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $endDate . ' ' . $endTime);

        if ($endDateTime->lessThan($startDateTime)) {
            $validator->errors()->add('endTime', 'El tiempo de finalización debe ser después del tiempo de inicio.');
        }
      });
    }
}