<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use Livewire\Attributes\Validate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role;

class Permission extends Component
{
    use LivewireAlert;

    protected $listeners = ['deleteComfirmedPermission'];

    #[Validate('required', message: '*')]
    public $permission = '';
    #[Validate('required', message: 'Select a role')]
    public $role;

    public $permissions;
    public $roles;

    public $getPermissionid;
    public $getPermission;

    public function render()
    {
        $this->permissions = ModelsPermission::all();
        $this->roles = Role::all();
        return view('livewire.admin.permission', [
            //'permissions' => $permissions,
        ]);
    }

    public function createPermission()
    {
        $this->validate([
            'permission' => 'required'
        ]);
        ModelsPermission::create([
            'name' => $this->permission,
            'guard_name' => 'web'
        ]);
        $this->reset('permissions');
        $this->alert('success', 'Created');
    }

    public function assignRole($permissionID, $permissionName)
    {
        $this->getPermission = ModelsPermission::where('id', $permissionID)->first();
    }

    public function createPermissionRole()
    {
        $this->validate([
            'role' => 'required'
        ]);
        if ($this->getPermission->hasRole($this->role)) {
            $this->alert('warning', 'Role already exist');
        } else {
            $this->getPermission->assignRole($this->role);
            $this->alert('success', 'Added successfully');
        }
    }

    public function revokeRole($permissionroleName)
    {
        if ($this->getPermission->hasRole($permissionroleName)) {
            $this->getPermission->removeRole($permissionroleName);
            $this->alert('success', 'Revoked');
        } else {
            $this->alert('warning', 'No role');
        }
    }
    public function editPermission($getId, $getName)
    {
        $this->getPermissionid = $getId;
        $this->permission = $getName;
    }

    public function updatePermission()
    {
        $permission = ModelsPermission::where('id', $this->getPermissionid)->first();
        $permission->name = $this->permission;
        $permission->save();
        $this->dispatch('updated');
    }

    public function deleteComfirmedPermission($id)
    {
        //dd('here');
        $permission = ModelsPermission::where('id', $id)->first();
        $permission->delete();
        $this->dispatch('deleted');
    }

    public function resetValues()
    {
        $this->reset('role', 'roles');
    }
}
