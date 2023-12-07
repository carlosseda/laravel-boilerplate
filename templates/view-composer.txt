<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Models\Language as DBLanguage;

class Language
{
  static $composed;

  public function __construct(DBLanguage $languages)
  {
    $this->languages = $languages; 
  }

  public function compose(View $view)
  {
    if(static::$composed)
    {
      return $view->with('languages', static::$composed);
    }

    static::$composed = $this->languages->orderBy('name', 'desc')->get();

    $view->with('languages', static::$composed);
  }
}