<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use Livewire\Attributes\Validate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends Component
{
    use LivewireAlert;

    protected $listeners = ['deleteComfirmedPermission'];

    #[Validate('required', message: '*')]
    public $permission = '';

    public $permissions;


    public $getPermissionid;
    public function render()
    {
        $this->permissions = ModelsPermission::all();
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
}
