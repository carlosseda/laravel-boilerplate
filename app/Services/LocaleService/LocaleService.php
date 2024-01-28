<?php

namespace App\Services\LocaleService;

use App\Models\Locale;

class LocaleService
{
  protected $entity;
  protected $language_alias;

  function __construct(private Locale $locale){}

  public function setEntity($entity)
  {
    $this->entity = $entity;
  }

  public function setLanguage($language_alias)
  {
    $this->language_alias = $language_alias;
  }

  public function store($locale, $entity_id)
  {  

    foreach ($locale as $name => $value){

      $name = str_replace(['-', '_'], ".", $name); 
      $explode_name = explode('.', $name);
      $language_alias = end($explode_name);
      array_pop($explode_name); 
      $key = implode(".", $explode_name); 

      $locale[] = $this->locale->updateOrCreate([
        'name' => $name,
        'language_alias' => $language_alias,
        'entity_id' => $entity_id,
        'entity' => $this->entity,
        'key' => $key,
      ],[
        'value' => $value,
      ]);
    }

    return $locale;
  }

  public function show($entity_id)
  {
    return Locale::getValues($this->entity, $entity_id)->pluck('value','key')->all();   
  }

  public function delete($key)
  {
    if (Locale::getValues($this->entity, $entity_id)->count() > 0) {
      Locale::getValues($this->entity, $entity_id)->delete();   
    }
  }

  public function getIdByLanguage($key){ 
    return Locale::getIdByLanguage($this->entity, $this->language_alias, $entity_id)->pluck('value','key')->all();
  }

  public function getAllByLanguage(){ 

    $items = Locale::getAllByLanguage($this->entity, $this->language_alias)->get()->groupBy('entity_id');

    $items =  $items->map(function ($item) {
      return $item->pluck('value','key');
    });

    return $items;
  }
}
    