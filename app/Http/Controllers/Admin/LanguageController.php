<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Http\Requests\Admin\LanguageRequest;

class LanguageController extends Controller
{
  public function __construct(private Language $language){}
  
  public function index()
  {
    try{

      $languages = $this->language
        ->orderBy('created_at', 'desc')
        ->paginate(10);
      
      if(request()->ajax()) {
            
        return response()->json([
          'table' => view('components.admin-table', ['tableStructure' => $this->language->getTableStructure(), 'records' => $languages])->render(),
          'form' => view('components.admin-form', ['formStructure' => $this->language->getFormStructure(), 'record' => $this->language])->render()
        ], 200); 

      }else{

        $view = View::make('admin.languages.index')
        ->with('tableStructure', $this->language->getTableStructure())
        ->with('formStructure', $this->language->getFormStructure())
        ->with('records', $languages)
        ->with('record', $this->language);

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
          'form' => view('components.admin-form', ['formStructure' => $this->language->getFormStructure(), 'record' => $this->language])->render(),
        ], 200);
      }
    } catch (\Exception $e) {
      return response()->json([
          'message' =>  \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function store(LanguageRequest $request)
  {            
    try{
      $data = $request->validated();
  
      $this->language->updateOrCreate([
        'id' => $request->input('id')
      ], $data);
  
      $languages = $this->language
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      if ($request->filled('id')){
        $message = \Lang::get('admin/notification.update');
      }else{
        $message = \Lang::get('admin/notification.create');
      }
      
      return response()->json([
        'table' => view('components.admin-table', ['tableStructure' => $this->language->getTableStructure(), 'records' => $languages])->render(),
        'form' => view('components.admin-form', ['formStructure' => $this->language->getFormStructure(), 'record' => $this->language])->render(),
        'message' => $message,
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function edit(Language $language)
  {
    try{
      return response()->json([
        'form' => view('components.admin-form', ['formStructure' => $this->language->getFormStructure(), 'record' => $language])->render(),
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function destroy(Language $language)
  {
    try{
      $language->delete();

      $languages = $this->language
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      $message = \Lang::get('admin/notification.destroy');
      
      return response()->json([
        'table' => view('components.admin-table', ['tableStructure' => $this->language->getTableStructure(), 'records' => $languages])->render(),
        'form' => view('components.admin-form', ['formStructure' => $this->language->getFormStructure(), 'record' => $this->language])->render(),
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