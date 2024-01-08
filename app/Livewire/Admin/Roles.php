<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Validate;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Roles extends Component
{
    use LivewireAlert;

    #[Validate('required', message: '*')]
    public $role = '';
    public $getRole;
    public $roles;
    public $getRoleId;
    public function render()
    {
        $this->roles = Role::all();
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
        $this->reset('roles');
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

    public function editRole($getId, $getName)
    {
        $this->getRoleId = $getId;
        $this->role = $getName;
        //dd($this->role);
    }

    public function updateRole()
    {
        $role = Role::where('id', $this->getRoleId)->first();
        $role->name = $this->role;
        $role->save();
        $this->dispatch('updated');
    }
}
