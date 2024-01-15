<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Admin\UserRequest;

class UserController extends Controller
{
  
  public function __construct(private User $user){}
  
  public function index()
  {
    try{

      $users = $this->user
        ->orderBy('created_at', 'desc')
        ->paginate(10);
      
      if(request()->ajax()) {
            
        return response()->json([
          'table' => view('components.admin-table', ['tableStructure' => $this->user->getTableStructure(), 'records' => $users])->render(),
          'form' => view('components.admin-form', ['formStructure' => $this->user->getFormStructure(), 'record' => $this->user])->render()
        ], 200); 

      }else{

        $view = View::make('admin.users.index')
        ->with('tableStructure', $this->user->getTableStructure())
        ->with('formStructure', $this->user->getFormStructure())
        ->with('records', $users)
        ->with('record', $this->user);

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
          'form' => view('components.admin-form', ['formStructure' => $this->user->getFormStructure(), 'record' => $this->user])->render(),
        ], 200);
      }
    } catch (\Exception $e) {
      return response()->json([
          'message' =>  \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function store(UserRequest $request)
  {            
    try{

      $data = $request->validated();

      unset($data['password_confirmation']);
      
      if (!$request->filled('password') && $request->filled('id')){
        unset($data['password']);
      }
  
      $this->user->updateOrCreate([
        'id' => $request->input('id')
      ], $data);

      $users = $this->user
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      if ($request->filled('id')){
        $message = \Lang::get('admin/notification.update');
      }else{
        $message = \Lang::get('admin/notification.create');
      }
      
      return response()->json([
        'table' => view('components.admin-table', ['tableStructure' => $this->user->getTableStructure(), 'records' => $users])->render(),
        'form' => view('components.admin-form', ['formStructure' => $this->user->getFormStructure(), 'record' => $this->user])->render(),
        'message' => $message,
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  public function edit(User $user)
  {
    try{
      return response()->json([
        'form' => view('components.admin-form', ['formStructure' => $this->user->getFormStructure(), 'record' => $user])->render(),
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function destroy(User $user)
  {
    try{
      $user->delete();

      $users = $this->user
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      $message = \Lang::get('admin/notification.destroy');
      
      return response()->json([
        'table' => view('components.admin-table', ['tableStructure' => $this->user->getTableStructure(), 'records' => $users])->render(),
        'form' => view('components.admin-form', ['formStructure' => $this->user->getFormStructure(), 'record' => $this->user])->render(),
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