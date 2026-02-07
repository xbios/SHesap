<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy('group');
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug',
            'permissions' => 'required|array'
        ]);

        $this->roleService->createRole($request->all());

        return redirect()->route('roles.index')->with('success', 'Rol başarıyla oluşturuldu.');
    }

    public function edit($id)
    {
        $role = $this->roleService->findOrFail($id);
        $permissions = Permission::all()->groupBy('group');
        $rolePermissionIds = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissionIds'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug,'.$id,
            'permissions' => 'required|array'
        ]);

        $this->roleService->updateRole($id, $request->all());

        return redirect()->route('roles.index')->with('success', 'Rol başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $this->roleService->delete($id);
        return redirect()->route('roles.index')->with('success', 'Rol başarıyla silindi.');
    }
}
