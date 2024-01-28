<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Requests\Admin\EventRequest;
use App\Services\LocaleService\LocaleService;
use Debugbar;

class EventController extends Controller
{
  public function __construct(private Event $event, private LocaleService $localeService){
    $this->localeService->setEntity('events');
  }
  
  public function index()
  {
    try{

      $events = $this->event
        ->orderBy('created_at', 'desc')
        ->paginate(10);
      
      if(request()->ajax()) {
            
        return response()->json([
          'table' => view('components.admin-table', ['tableStructure' => $this->event->getTableStructure(), 'records' => $events])->render(),
          'form' => view('components.admin-form', ['formStructure' => $this->event->getFormStructure(), 'record' => $this->event])->render()
        ], 200); 

      }else{

        $view = View::make('admin.events.index')
        ->with('tableStructure', $this->event->getTableStructure())
        ->with('formStructure', $this->event->getFormStructure())
        ->with('records', $events)
        ->with('record', $this->event);

        return $view;
      }
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function create()
  {
    try {
      if (request()->ajax()) {
        return response()->json([
          'form' => view('components.admin-form', ['formStructure' => $this->event->getFormStructure(), 'record' => $this->event])->render(),
        ], 200);
      }
    } catch (\Exception $e) {
      return response()->json([
          'message' =>  \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function store(EventRequest $request)
  {            
    try{
      $data = $request->validated();
  
      $event = $this->event->updateOrCreate([
        'id' => $request->input('id')
      ], $data);
  
      $events = $this->event
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      if(request('locale')){
        $locale = $this->localeService->store(request('locale'), $event->id);
      }

      if ($request->filled('id')){
        $message = \Lang::get('admin/notification.update');
      }else{
        $message = \Lang::get('admin/notification.create');
      }
      
      return response()->json([
        'table' => view('components.admin-table', ['tableStructure' => $this->event->getTableStructure(), 'records' => $events])->render(),
        'form' => view('components.admin-form', ['formStructure' => $this->event->getFormStructure(), 'record' => $this->event])->render(),
        'message' => $message,
      ], 200);
    }
    catch(\Exception $e){
      Debugbar::error($e);  
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function edit(Event $event)
  {
    try{
      $locales = $event->locales()->pluck('value', 'name')->all();
      
      foreach ($locales as $name => $value) {
        $event->$name = $value;
      }

      Debugbar::info($event);
      return response()->json([
        'form' => view('components.admin-form', ['formStructure' => $this->event->getFormStructure(), 'record' => $event])->render(),
      ], 200);
    }
    catch(\Exception $e){
      Debugbar::error($e);
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function destroy(Event $event)
  {
    try{
      $event->delete();

      $events = $this->event
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      $message = \Lang::get('admin/notification.destroy');
      
      return response()->json([
        'table' => view('components.admin-table', ['tableStructure' => $this->event->getTableStructure(), 'records' => $events])->render(),
        'form' => view('components.admin-form', ['formStructure' => $this->event->getFormStructure(), 'record' => $this->event])->render(),
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