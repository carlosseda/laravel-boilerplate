<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use SoftDeletes;

  protected $guarded = [];
  protected $dates = ['deleted_at'];

  public function getTableStructure()
  {
    return [
      'columns' => [
        'name' => 'Nombre',
			'user_id' => 'Usuario'
      ],
      'filters' => [
        				["name" => "name", "label" => "Nombre", "type" => "text", "width" => "full-width", "attributes" => ["autocomplete" => true]],
				["name" => "user_id", "label" => "Usuario", "type" => "select", "width" => "full-width", "attributes" => ["required" => true], "options" => ["related" => "users"]],

      ],
      'tableButtons' => ['filterButton'],
      'recordButtons' => [
        'editButton' => 'products_edit',
        'destroyButton' => 'products_destroy',
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
    'createButton' => 'products_create',
    'storeButton' => 'products_store',
  ],
  'inputs' => [
    'general' => [
      'noLocale' => [
				["name" => "name", "label" => "Nombre", "type" => "text", "width" => "full-width", "attributes" => ["autocomplete" => true]],
				["name" => "user_id", "label" => "Usuario", "type" => "select", "width" => "full-width", "attributes" => ["required" => true], "options" => ["related" => "users"]],

      ],
      'locale' => [
				["name" => "title", "label" => "Título", "type" => "text", "width" => "full-width", "attributes" => ["required" => true]],

      ]
    ]
  ]   
];
  }
}
