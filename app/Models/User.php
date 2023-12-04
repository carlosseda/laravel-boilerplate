<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
  use SoftDeletes;

  protected $guarded = [];
  protected $dates = ['deleted_at'];  

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  public function getTableStructure()
  {
    return [
      'columns' => [
        'name' => 'Nombre',
        'email' => 'Email',
        'created_at' => 'Fecha de creación',
        'updated_at' => 'Fecha de actualización',
      ],
      'filters' => [
        ['name' => 'name', 'type' => 'text', 'label' => 'Nombre', 'width' => 'full-width'],
        ['name' => 'email', 'type' => 'email', 'label' => 'Email', 'width' => 'full-width']
      ],
      'tableButtons' => ['filterButton'],
      'recordButtons' => [
        'editButton' => 'users_edit',
        'destroyButton' => 'users_destroy',
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
        'createButton' => 'users_create',
        'storeButton' => 'users_store',
      ],
      'inputs' => [
        'general' => [
          'noLocale' => [
            ['name' => 'name', 'type' => 'text', 'label' => 'Nombre', 'width' => 'half-width'],
            ['name' => 'email', 'type' => 'email', 'label' => 'Email', 'width' => 'half-width'],
            ['name' => 'password', 'type' => 'password', 'label' => 'Contraseña', 'width' => 'half-width'],
            ['name' => 'password_confirmation', 'type' => 'password', 'label' => 'Confirmar contraseña', 'width' => 'half-width'],
          ]
        ],
        'images' => [
          'noLocale' => [
            ['name' => 'image', 'type' => 'file', 'label' => 'Imagen', 'width' => 'full-width'],
          ]
        ],
      ]
    ];
  }
}
