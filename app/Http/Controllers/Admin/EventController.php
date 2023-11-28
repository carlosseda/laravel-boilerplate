<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Requests\Admin\EventRequest;

class EventController extends Controller
{
  public function __construct(private Event $event){}
  
  public function index()
  {
    try{
      $view = View::make('admin.events.index')
      ->with('event', $this->event)
      ->with('events', $this->event
      ->orderBy('created_at', 'desc')
      ->paginate(10));
  
      if(request()->ajax()) {
          
        $sections = $view->renderSections(); 
  
        return response()->json([
          'table' => $sections['table'],
          'form' => $sections['form'],
        ], 200); 
      }
  
      return $view;
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function create()
  {
    try{
      $view = View::make('admin.events.index')
      ->with('event', $this->event)
      ->with('events', $this->event
      ->orderBy('created_at', 'desc')
      ->paginate(10));
  
      if(request()->ajax()) {
  
        $sections = $view->renderSections(); 
  
        return response()->json([
          'form' => $sections['form'],
        ], 200);
      }
  
      return $view;
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function store(EventRequest $request)
  {            
    try{
      $eventData = [
        'name' => $request->input('name'),
        'address' => $request->input('address'),
        'price' => $request->input('price'),
        'date' => $request->input('date'),
        'time' => $request->input('time'),
      ];
  
      $event = event::updateOrCreate([
        'id' => $request->input('id')
      ], $eventData);
  
      if ($request->filled('id')){
        $message = \Lang::get('admin/notification.update');
      }else{
        $message = \Lang::get('admin/notification.create');
      }
  
      $view = View::make('admin.events.index')
      ->with('event', $this->event)
      ->with('events', $this->event
      ->orderBy('created_at', 'desc')
      ->paginate(10))
      ->renderSections();        
  
      return response()->json([
        'table' => $view['table'],
        'form' => $view['form'],
        'message' => $message,
        'id' => $event->id,
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function edit(event $event)
  {
    try{
      $view = View::make('admin.events.index')
      ->with('event', $event)
      ->with('events', $this->event
      ->orderBy('created_at', 'desc')
      ->paginate(10));
  
      if(request()->ajax()) {
  
        $sections = $view->renderSections(); 
  
        return response()->json([
          'form' => $sections['form'],
        ]); 
      }
  
      return $view;
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function destroy(event $event)
  {
    try{
      $event->delete();
      $message = \Lang::get('admin/notification.destroy');
  
      $view = View::make('admin.events.index')
      ->with('event', $this->event)
      ->with('events', $this->event
      ->orderBy('created_at', 'desc')
      ->paginate(10))
      ->renderSections();
      
      return response()->json([
        'table' => $view['table'],
        'form' => $view['form'],
        'message' => $message,
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }
}