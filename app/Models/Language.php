<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
  use SoftDeletes;

  protected $guarded = [];
  protected $dates = ['deleted_at'];

  public function getTableStructure()
  {
    return [
      'columns' => [
        'name' => 'Nombre',
        'label' => 'Alias',
      ],
      'filters' => [
        ['name' => 'name', 'type' => 'text', 'label' => 'Nombre', 'width' => 'full-width'],
        ['name' => 'label', 'type' => 'text', 'label' => 'Alias', 'width' => 'full-width'],
      ],
      'tableButtons' => ['filterButton'],
      'recordButtons' => [
        'editButton' => 'languages_edit',
        'destroyButton' => 'languages_destroy',
      ]
    ];
  }

  public function getFormStructure()
  {
    return [
      'tabs' => [
        ['name' => 'general', 'label' => 'General'],
      ],
      'formButtons' => [
        'createButton' => 'languages_create',
        'storeButton' => 'languages_store',
      ],
      'inputs' => [
        'general' => [
          'noLocale' => [
            ['name' => 'name', 'type' => 'text', 'label' => 'Nombre', 'width' => 'half-width'],
            ['name' => 'label', 'type' => 'text', 'label' => 'Alias', 'width' => 'half-width'],
          ]
        ]
      ]
    ];
  }
}