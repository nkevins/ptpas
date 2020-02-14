<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Role;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        
        return view('admin/user/index', compact('users'));
    }
    
    public function create()
    {
        $roles = Role::all();
        
        return view('admin/user/create', compact('roles'));
    }
    
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:password',
            'roles' => 'required'
        ]);

        if ($validator->fails()) {
            flash()->error($validator->errors()->first())->important();
            return redirect()->back()->withInput();
        }
    
        $roles = $request->input('roles');
        
        $u = new User;
        $u->name = $request->input('name');
        $u->username = $request->input('username');
        $u->password = Hash::make($request->input('password'));
        if ($request->input('email') != '')
            $u->email = $request->input('email');
        else
            $u->email = '';
        $u->active = true;
        $u->save();
        $u->roles()->sync($roles);
        
        flash()->success('User Created')->important();
        return redirect()->action('UserController@index');
    }
    
    public function edit($id)
    {
        $roles = Role::all();
        $user = User::with('roles')->find($id);
        
        if ($user == null) {
            abort(404);
        }
        
        return view('admin/user/edit', compact('user', 'roles'));
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => [
                            'required',
                            Rule::unique('users')->ignore($id),
                        ],
            'roles' => 'required'
        ]);

        if ($validator->fails()) {
            flash()->error($validator->errors()->first())->important();
            return redirect()->back()->withInput();
        }
        
        $roles = $request->input('roles');
        
        $u = User::findOrFail($id);
        $u->name = $request->input('name');
        $u->username = $request->input('username');
        if ($request->input('email') != '')
            $u->email = $request->input('email');
        else
            $u->email = '';
        $u->active = $request->input('active') == "1" ? true : false;
        $u->save();
        $u->roles()->sync($roles);
        
        flash()->success('User Update')->important();
        return redirect()->action('UserController@index');
    }
    
    public function changePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:password',
        ]);

        if ($validator->fails()) {
            flash()->error($validator->errors()->first())->important();
            return redirect()->back()->withInput();
        }
        
        $u = User::findOrFail($id);
        $u->password = Hash::make($request->input('password'));
        $u->save();
         
        flash()->success('User Password CHanged')->important();
        return redirect()->action('UserController@index');
    }
}
