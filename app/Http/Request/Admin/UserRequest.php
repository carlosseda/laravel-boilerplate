<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:64|regex:/^[a-z0-9áéíóúàèìòùäëïöüñ\s]+$/i',
            'email' => ['required','email','max:255', Rule::unique('t_users')->ignore($this->id)],
            'password' => 'required_without:id',
            'password_confirmation' => 'required_without:id|same:password'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'El mínimo de caracteres permitidos para el nombre son 3',
            'name.max' => 'El máximo de caracteres permitidos para el nombre son 64',
            'name.regex' => 'Sólo se aceptan letras para el nombre',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El formato de email es incorrecto',
            'email.max' => 'El máximo de caracteres permitidos para el email son 255',
            'email.unique' => 'El email ya existe',
            'password.required_without' => 'La contraseña es obligatoria',
            'password.required_without' => 'La contraseña no coinciden',
            'password_confirmation.same' => 'Las contraseñas no coinciden'
        ];
    }
}