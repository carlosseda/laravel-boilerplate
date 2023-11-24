<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Request\Admin\UserRequest;

class UserController extends Controller
{
    public function __construct(private User $user)
    {
        // $this->middleware('auth');
    }
    
    public function index()
    {
      $view = View::make('admin.users.index')->with('users', $this->user->get());

      if(request()->ajax()) {
          
        $sections = $view->renderSections(); 

        return response()->json([
            'table' => $sections['table'],
            'form' => $sections['form'],
        ]); 
      }

      return $view;
    }

    public function store(UserRequest $request)
    {            
        
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

      $view = View::make('admin.users.index')
      ->with('users', $this->user->get())
      ->with('user', $user)
      ->renderSections();        

      return response()->json([
        'table' => $view['table'],
        'form' => $view['form'],
        'id' => $user->id,
      ]);
    }

    public function edit(User $user)
    {
      $view = View::make('admin.users.index')
      ->with('user', $user)
      ->with('users', $this->user->where('active', 1)->get());   
      
      if(request()->ajax()) {

          $sections = $view->renderSections(); 
  
          return response()->json([
              'form' => $sections['form'],
          ]); 
      }
              
      return $view;
    }

    public function destroy(User $user)
    {
        $user->active = 0;
        $user->save();

        $view = View::make('admin.users.index')
            ->with('user', $this->user)
            ->with('users', $this->user->where('active', 1)->get())
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form']
        ]);
    }
}