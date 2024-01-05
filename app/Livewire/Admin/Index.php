<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HrisEmployee;
use App\Models\User;

class Index extends Component
{
    use WithPagination;

    public $search_employee = '';
    protected $getEmployees;
    protected $employeelist;
    public $selectedEmployees;
    public $showDiv;
    // public function updatedSearchEmployee()
    // {
    //     $columns = ['emp_id', 'lastname', 'firstname'];


    //     $this->getEmployees = HrisEmployee::select('emp_id', 'lastname', 'firstname', 'middlename', 'emp_id')->where(function ($query) use ($columns) {
    //         foreach ($columns as $column) {
    //             $query->orWhere($column, 'LIKE', '%' . $this->search_employee);
    //         }
    //     })->paginate(6, ['*'], 'employeelist');
    // }

    public function render()
    {


        $columns = ['emp_id', 'lastname', 'firstname'];
        if (strlen($this->search_employee) > 0) {
            $this->getEmployees = HrisEmployee::select('emp_id', 'lastname', 'firstname', 'middlename', 'emp_id')->where(function ($query) use ($columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . $this->search_employee);
                }
            })->paginate(6, ['*'], 'employeelist');
        }


        $users = User::all();

        return view('livewire.admin.index', [
            'users' => $users,
            //'users' => HrisEmployee::search($this->search_employee)->get(),
        ]);
    }

    public function selectedEmployee($getId)
    {
        $this->selectedEmployees = HrisEmployee::where('emp_id', sprintf('%06d', $getId))->first();
        $this->resetExcept('selectedEmployees', 'getEmployees', 'showDiv', 'search_employee', 'employeelist');
    }

    public function openDiv()
    {
        $this->showDiv = !$this->showDiv;
    }
}
