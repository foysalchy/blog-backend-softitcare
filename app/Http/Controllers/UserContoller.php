<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Hash;

class UserContoller extends Controller
{
    
    
    public function index()
    {
        $users = User::with('roles', 'permissions')->get();
        return response()->json($users);
    }
    public function roles(){
        $roles=DB::table('roles')->get();
        return response()->json($roles);

    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        
        $user->assignRole($request->role_id);

        return response()->json($user, 201);
    }

    

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role_id' => 'required' // ensure role is provided
        ]);
    
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
    
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        $user->update($data);
    
        // Remove old roles and assign new role
        $user->syncRoles([$request->role_id]);
    
        return response()->json($user);
    }

    public function destroy(User $user)
    {
      

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
