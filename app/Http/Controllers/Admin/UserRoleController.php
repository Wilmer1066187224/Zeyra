<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
{
    
    if (!auth()->user()->can('gestionar roles')) {
        return redirect()->route('permission.denied');
    }


    $users = User::with('roles', 'permissions')->get();
    $roles = Role::all();
    $permissions = \Spatie\Permission\Models\Permission::all();

    return view('admin.user_roles.index', compact('users', 'roles', 'permissions'));
}


   public function update(Request $request, User $user)
{
    $request->validate([
        'role' => 'required|exists:roles,name',
        'permissions' => 'array'
    ]);

    // Asigna el nuevo rol
    $user->syncRoles($request->role);

    // Asigna permisos específicos
    $user->syncPermissions($request->permissions ?? []);

    return redirect()->route('admin.user-roles.index')->with('swal', 'Rol y permisos actualizados correctamente.');
}

    
}
