<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];
  protected $dates = ['deleted_at'];

  public function town()
  {
    return $this->belongsTo(Town::class);
  }

  public function locales()
  {
    return $this->hasMany(Locale::class, 'entity_id')->where('entity', 'events');
  }

  public function traductions()
  {
    return $this->hasMany(Locale::class, 'entity_id')->where('entity', 'events')->where('language_alias', App::getLocale());
  }

  public function getTableStructure()
  {
    return [
      'columns' => [
        'name' => 'Nombre',
        'start_date' => 'Fecha de inicio',
        'start_time' => 'Hora de inicio',
        'created_at' => 'Fecha de creación',
        'updated_at' => 'Fecha de actualización'
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
            ['name' => 'name', 'type' => 'text', 'label' => 'Nombre', 'width' => 'half-width'],
            ['name' => 'town_id', 'label' => 'Población', 'type' => 'select', 'width' => 'half-width', 'options' => [
              ['value' => '1', 'label' => 'Opción 1'],
              ['value' => '2', 'label' => 'Opción 2', 'selected' => 'selected'],
              ['value' => '3', 'label' => 'Opción 3'],
            ]],
            ['name' => 'address', 'type' => 'text', 'label' => 'Dirección', 'width' => 'half-width'],
            ['name' => 'price', 'type' => 'number', 'label' => 'Precio', 'width' => 'half-width'],
            ['name' => 'start_date', 'type' => 'date', 'label' => 'Fecha de Inicio', 'width' => 'half-width'],
            ['name' => 'end_date', 'type' => 'date', 'label' => 'Fecha de Fin', 'width' => 'half-width'],
            ['name' => 'start_time', 'type' => 'time', 'label' => 'Hora de Inicio', 'width' => 'half-width'],
            ['name' => 'end_time', 'type' => 'time', 'label' => 'Hora de Fin', 'width' => 'half-width'],
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
