<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
  public function __construct(private Event $event){}
  
  public function show($id)
  {
    try{

      $event = $this->event->with('town')->with('traductions')->find($id);

      $view = View::make('front.event.index')->with('event', $event);
      
      return $view;
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }
}