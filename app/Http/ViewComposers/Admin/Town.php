<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Models\Town as DBTown;

class Town
{
  static $composed;

  public function __construct(DBTown $towns)
  {
    $this->towns = $towns; 
  }

  public function compose(View $view)
  {
    if(static::$composed)
    {
      return $view->with('towns', static::$composed);
    }

    static::$composed = $this->towns->orderBy('name', 'desc')->get();

    $view->with('towns', static::$composed);
  }
}