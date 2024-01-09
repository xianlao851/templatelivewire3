<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Validate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Spatie\Permission\Models\Permission;

class Roles extends Component
{
    use LivewireAlert;

    #[Validate('required', message: '*')]
    public $role = '';
    #[Validate('required', message: 'Select a permission')]
    public $permission = '';

    public $permission_id = 0;

    public $roles;
    public $permissions;

    public $getRoleId;
    public $getRole;

    public $bol = false;

    public function render()
    {

        $this->roles = Role::all();
        $this->permissions = Permission::all();
        return view('livewire.admin.roles', [
            //'roles' => $this->roles,
        ]);
    }

    public function createUser()
    {
        $this->validate([
            'role' => 'required'
        ]);
        Role::create([
            'name' => $this->role,
            'guard_name' => 'web'
        ]);
        $this->alert('success', 'Created');
        $this->resetExcept('bol');
    }
    public function assignPermission($getId, $getName)
    {
        $this->getRoleId = $getId;
        $this->role = $getName;
        $this->getRole = Role::where('id', $getId)->first();
    }
    public function createRolePermission()
    {
        $this->validate([
            'permission' => 'required'
        ]);
        if ($this->getRole->hasPermissionTo($this->permission)) {
            $this->alert('warning', 'Permission already exist');
        } else {
            $this->getRole->givePermissionTo($this->permission);
            $this->alert('success', 'Added');
        }
        $this->reset('permission', 'permissions');
    }

    public function revokePermission($roles_permissionName)
    {
        if ($this->getRole->hasPermissionTo($roles_permissionName)) {
            $this->getRole->revokePermissionTo($roles_permissionName);
            $this->alert('success', 'Revoked');
        } else {
            //$this->getRole->givePermissionTo($roles_permissionId);
            $this->alert('warning', 'No permission');
        }
        $this->resetExcept('bol', 'permission', 'getRole', 'role');
    }
    public function editRole($getId, $getName)
    {
        $this->getRoleId = $getId;
        $this->role = $getName;
        $this->getRole = Role::where('id', $getId)->first();
        //dd($this->getRole);
    }

    public function updateRole()
    {
        $role = Role::where('id', $this->getRoleId)->first();
        $role->name = $this->role;
        $role->save();
        $this->resetExcept('bol');
        $this->dispatch('updated');
    }

    public function delete($id)
    {
        $role = Role::where('id', $id)->first();
        $role->delete();
        $this->alert('success', 'Deleted', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Ok'
        ]);
    }

    public function resetvalues()
    {
        $this->reset('bol', 'permission', 'getRole', 'role', 'permissions');
    }
}