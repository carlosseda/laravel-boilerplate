<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
  protected $guarded = [];
  protected $dates = ['deleted_at'];

  public function scopeGetValues($query, $entity, $entity_id){
    return $query->where('entity_id', $entity_id)
      ->where('entity', $entity);
  }

  public function scopeGetIdByLanguage($query, $entity, $language_alias, $entity_id){
      
    return $query->where('entity_id', $entity_id)
      ->where('language_alias', $language_alias)
      ->where('entity', $entity);
  }

  public function scopeGetAllByLanguage($query, $entity, $language_alias){

    return $query->where('language_alias', $language_alias)
      ->where('entity', $entity);
  }
}