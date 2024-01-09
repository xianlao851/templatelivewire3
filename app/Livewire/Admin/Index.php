<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HrisEmployee;
use App\Models\User;
use Livewire\Attributes\Validate;
use Spatie\Permission\Models\Role;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;
    use WithPagination;

    #[Validate('required', message: '*')]
    public $role = '';

    public $search_employee = '';

    public $roles;

    public $selectedEmployeeId;
    public $selectedEmployees;

    protected $getEmployees;
    public $getUser;
    public $getUserRoles;
    public $getUserId;
    public $showDiv;

    public function updatedSearchEmployee()
    {
        $this->resetPage();
    }
    public function render()
    {


        $columns = ['emp_id', 'lastname', 'firstname'];
        if (strlen($this->search_employee) > 0) {
            $this->getEmployees = HrisEmployee::select('emp_id', 'lastname', 'firstname', 'middlename', 'emp_id')->where(function ($query) use ($columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . $this->search_employee);
                }
            })->paginate(5, pageName: 'employee-list');
        }


        $users = User::all();
        $this->roles = Role::all();
        return view('livewire.admin.index', [
            'users' => $users,
            //'getUserRoles' => $this->getUserRoles

        ]);
    }

    public function selectedEmployee($getId)
    {
        $this->selectedEmployeeId = sprintf('%06d', $getId);
        $this->selectedEmployees = HrisEmployee::where('emp_id', sprintf('%06d', $getId))->first();
    }

    public function openDiv()
    {
        $this->showDiv = !$this->showDiv;
        $this->resetExcept('showDiv');
        $this->resetPage(pageName: 'employee-list');
    }

    public function createUser()
    {
        //dd($this->selectedEmployeeId);
        $this->validate(
            [
                'role' => 'required',
                //'selectedEmployeeId ' => 'required'
            ]
        );
    }

    public function viewRole($getId)
    {
        $this->getUserId = $getId;
        $this->getUser = User::where('id', $getId)->first();
        $this->getUserRoles = $this->getUser->roles;
    }

    public function createRole()
    {
        $this->validate([
            'role' => 'required'
        ]);
        if ($this->getUser->hasRole($this->role)) {
            $this->alert('warning', 'Role already exist');
        } else {
            $this->getUser->assignRole($this->role);
            $this->alert('success', 'Role created');
        }
        //$this->getUserRoles = $this->getUser->fresh();
        $this->getUser = User::where('id',  $this->getUserId)->first();
        $this->getUserRoles = $this->getUser->roles;
        dd($this->getUserRoles);
    }
    public function revokeRole($roleName)
    {
        $this->getUser->removeRole($roleName);
        $this->alert('success', 'Role revoked');
        $this->getUserRoles = $this->getUser->roles->fresh();
    }
    public function reset_values()
    {
        $this->resetPage(pageName: 'employee-list');
        $this->resetExcept('showDiv');
        //return redirect()->to('/admin_index');
    }
}
