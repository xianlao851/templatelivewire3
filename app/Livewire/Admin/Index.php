<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HrisEmployee;
use App\Models\User;
use Livewire\Attributes\Validate;

class Index extends Component
{
    use WithPagination;
    #[Validate('required', message: '*')]
    public $role;

    public $selectedEmployeeId;
    public $search_employee = '';
    protected $getEmployees;
    //public $employeelist;
    public $selectedEmployees;
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

        return view('livewire.admin.index', [
            'users' => $users,
            //'users' => HrisEmployee::search($this->search_employee)->get(),
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
    }

    public function createUser()
    {
        $this->validate(
            [
                'role' => 'required',
                'selectedEmployeeId ' => 'required'
            ]
        );
    }
}
