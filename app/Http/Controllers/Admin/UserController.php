<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Admin\UserRequest;

class UserController extends Controller
{
  public function __construct(private User $user)
  {
    // $this->middleware('auth');
  }
  
  public function index()
  {
    try{
      $view = View::make('admin.users.index')
      ->with('user', $this->user)
      ->with('users', $this->user
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
      $view = View::make('admin.users.index')
      ->with('user', $this->user)
      ->with('users', $this->user
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

  public function store(UserRequest $request)
  {            
    try{
      $userData = [
        'name' => $request->input('name'),
        'email' => $request->input('email'),
      ];
  
      if ($request->filled('password')) {
        $userData['password'] = bcrypt($request->input('password'));
      }
  
      $user = User::updateOrCreate([
        'id' => $request->input('id')
      ], $userData);
  
      if ($request->filled('id')){
        $message = \Lang::get('admin/notification.update');
      }else{
        $message = \Lang::get('admin/notification.create');
      }
  
      $view = View::make('admin.users.index')
      ->with('user', $this->user)
      ->with('users', $this->user
      ->orderBy('created_at', 'desc')
      ->paginate(10))
      ->renderSections();        
  
      return response()->json([
        'table' => $view['table'],
        'form' => $view['form'],
        'message' => $message,
        'id' => $user->id,
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function edit(User $user)
  {
    try{
      $view = View::make('admin.users.index')
      ->with('user', $user)
      ->with('users', $this->user
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

  public function destroy(User $user)
  {
    try{
      $user->delete();
      $message = \Lang::get('admin/notification.destroy');
  
      $view = View::make('admin.users.index')
      ->with('user', $this->user)
      ->with('users', $this->user
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