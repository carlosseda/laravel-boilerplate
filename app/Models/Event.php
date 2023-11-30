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
  }
}
