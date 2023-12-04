<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
  use SoftDeletes;

  protected $guarded = [];
  protected $dates = ['deleted_at'];

  public function getTableStructure()
  {
    return [
      'columns' => [
        'name' => 'Nombre',
        'date' => 'Fecha',
        'time' => 'Hora'
      ],
      'filters' => [
        ['name' => 'name', 'type' => 'text', 'label' => 'Nombre', 'width' => 'full-width'],
        ['name' => 'date', 'type' => 'date', 'label' => 'Fecha', 'width' => 'full-width'],
        ['name' => 'time', 'type' => 'time', 'label' => 'Hora', 'width' => 'full-width']
      ],
      'tableButtons' => ['filterButton'],
      'recordButtons' => [
        'editButton' => 'events_edit',
        'destroyButton' => 'events_destroy',
      ]
    ];
  }

  public function getFormStructure()
  {
    return [
      'tabs' => [
        ['name' => 'general', 'label' => 'General'],
        ['name' => 'images', 'label' => 'Imágenes']
      ],
      'formButtons' => [
        'createButton' => 'events_create',
        'storeButton' => 'events_store',
      ],
      'inputs' => [
        'general' => [
          'noLocale' => [
            ['name' => 'name', 'type' => 'text', 'label' => 'Nombre', 'width' => 'full-width'],
            ['name' => 'address', 'type' => 'text', 'label' => 'Dirección', 'width' => 'half-width'],
            ['name' => 'price', 'type' => 'number', 'label' => 'Precio', 'width' => 'half-width'],
            ['name' => 'date', 'type' => 'date', 'label' => 'Fecha', 'width' => 'half-width'],
            ['name' => 'time', 'type' => 'time', 'label' => 'Hora', 'width' => 'half-width'],
          ],
          'locale' => [
            ['name' => 'title', 'type' => 'text', 'label' => 'Título', 'width' => 'full-width'],
            ['name' => 'description', 'type' => 'textarea', 'label' => 'Descripción', 'width' => 'full-width'],
          ], 
        ],
        'images' => [
          'noLocale' => [
            ['name' => 'image', 'type' => 'file', 'label' => 'Imagen', 'width' => 'full-width'],
          ],
        ],
      ]
    ];

    // return [
    //   'tabs' => [
    //     ['name' => 'general', 'label' => 'General'],
    //   ],
    //   'formButtons' => [
    //     'createButton' => 'events_create',
    //     'storeButton' => 'events_store',
    //   ],
    //   'inputs' => [
    //     'general' => [
    //       'noLocale' => [
    //         ['name' => 'description', 'label' => 'Descripción', 'type' => 'textarea', 'width' => 'full-width', 'attributes' => [ 'maxlength' => 1000, 'minlength' => 10, 'placeholder' => 'Escriba aquí', 'required' => true]],
    //         ['name' => 'document', 'label' => 'Documento', 'type' => 'file', 'width' => 'full-width', 'attributes' => ['accept' => 'application/pdf', 'required' => true]],
    //         ['name' => 'date', 'label' => 'Fecha', 'type' => 'date', 'width' => 'half-width', 'attributes' => ['max' => '2023-12-31', 'min' => '2023-01-01', 'required' => true]],
    //         ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'width' => 'half-width', 'attributes' => ['maxlength' => 255, 'minlength' => 3, 'placeholder' => 'Nombre completo', 'required' => true]],
    //         ['name' => 'options', 'label' => 'Opciones', 'type' => 'select', 'width' => 'full-width', 'attributes' => ['multiple' => true, 'required' => true], 'options' => [
    //           ['value' => '1', 'label' => 'Opción 1'],
    //           ['value' => '2', 'label' => 'Opción 2', 'selected' => 'selected'],
    //           ['value' => '3', 'label' => 'Opción 3'],
    //         ]],
    //         ['name' => 'gender', 'label' => 'Sexo', 'type' => 'radio', 'width' => 'full-width', 'options' => [
    //           ['value' => '1', 'label' => 'Opción 1'],
    //           ['value' => '2', 'label' => 'Opción 2', 'checked' => 'checked'],
    //           ['value' => '3', 'label' => 'Opción 3']
    //         ]],
    //         ['name' => 'friends', 'label' => 'Sexo', 'type' => 'checkbox', 'width' => 'full-width', 'options' => [
    //           ['value' => '1', 'label' => 'Opción 1'],
    //           ['value' => '2', 'label' => 'Opción 2', 'checked' => 'checked'],
    //           ['value' => '3', 'label' => 'Opción 3'],
    //         ]],
    //         ['name' => 'color', 'label' => 'Color', 'type' => 'color', 'width' => 'half-width'],
    //         ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'width' => 'half-width', 'attributes' => ['placeholder' => 'email@example.com', 'required' => true]],
    //         ['name' => 'image', 'label' => 'Imagen', 'type' => 'image', 'width' => 'half-width', 'attributes' => ['src' => 'path/to/image', 'alt' => 'Image']],
    //         ['name' => 'month', 'label' => 'Mes', 'type' => 'month', 'width' => 'half-width', 'attributes' => ['required' => true]],
    //         ['name' => 'number', 'label' => 'Número', 'type' => 'number', 'width' => 'half-width', 'attributes' => ['min' => 1, 'max' => 100, 'required' => true]],
    //         ['name' => 'password', 'label' => 'Contraseña', 'type' => 'password', 'width' => 'half-width', 'attributes' => ['required' => true, 'autocomplete' => true]],
    //         ['name' => 'range', 'label' => 'Rango', 'type' => 'range', 'width' => 'half-width', 'attributes' => ['min' => 0, 'max' => 100, 'step' => 1, 'value' => 50]],
    //         ['name' => 'search', 'label' => 'Búsqueda', 'type' => 'search', 'width' => 'half-width', 'attributes' => ['required' => true]],
    //         ['name' => 'tel', 'label' => 'Teléfono', 'type' => 'tel', 'width' => 'half-width', 'attributes' => ['required' => true]],
    //         ['name' => 'time', 'label' => 'Hora', 'type' => 'time', 'width' => 'half-width', 'attributes' => ['required' => true]],
    //         ['name' => 'url', 'label' => 'URL', 'type' => 'url', 'width' => 'half-width', 'attributes' => ['required' => true]],
    //         ['name' => 'week', 'label' => 'Semana', 'type' => 'week', 'width' => 'half-width', 'attributes' => ['required' => true]],
    //         ['name' => 'datetime', 'label' => 'Fecha y Hora', 'type' => 'datetime-local', 'width' => 'half-width', 'attributes' => ['required' => true]]
    //       ],
    //     ]
    //   ]   
    // ];
  }
}
