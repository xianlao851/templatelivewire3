<div class="mt-4">
    <div class="flex flex-col max-w-6xl p-1 mx-auto bg-white rounded-md ">
        <div class="relative h-12 border-b-2">
            <div class="absolute left-0 top-3">
                <h3 class="mx-1">Admin Dashboard</h3>
            </div>
            <div class="absolute right-0 top-2">
                <label class="bg-gray-300 btn btn-sm hover:bg-gray-400" wire:click='openDiv'> <i
                        class="las la-plus-circle la-2x"></i></label>
            </div>
        </div>

        @if ($showDiv)
            <div class="grid grid-cols-2 p-2 mt-2">
                <div>
                    <div class="mt-2 ">
                        <div class="w-full join">
                            <input class="w-96 input input-bordered join-item" placeholder="Search..."
                                wire:model.change='search_employee' />
                            <button class="rounded-r-full btn join-item">Search</button>
                        </div>
                    </div>

                    <div class="h-64 w-96">
                        <ul class="">
                            @if ($this->getEmployees)
                                @forelse ($this->getEmployees as $employee)
                                    <li class="p-1 mt-2 rounded-md cursor-pointer bg-stone-300 hover:bg-stone-400"
                                        wire:click='selectedEmployee({{ $employee->emp_id }})'>
                                        {{ $employee->lastname }},
                                        {{ $employee->firstname }}
                                    </li>
                                @empty
                                @endforelse
                            @endif
                        </ul>
                        <div class="mt-2">
                            @if ($this->getEmployees != null)
                                {{ $this->getEmployees->links() }}
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    @if ($this->selectedEmployees)
                        <div>{{ $this->selectedEmployees->lastname }}, {{ $selectedEmployees->firstname }}</div>
                    @endif
                </div>

            </div>
        @endif
        <div class="">
            <div class="overflow-x-auto">
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @forelse ($users as $user)
                                <td class="uppercase">{{ $user->name }}</td>
                                <td class="uppercase">Empty</td>
                                <td class="uppercase">Empty</td>
                            @empty
                            @endforelse

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal-->

        <input type="checkbox" id="addUser" class="modal-toggle" /> <!-- Add user-->
        <div class="modal" role="dialog">
            <div class="modal-box">
                <h3 class="text-lg font-bold">Add User</h3>
                <div class="w-full mt-2">
                    <div class="w-full join">
                        <input class="w-96 input input-bordered join-item" placeholder="Search..."
                            wire:model.blur='search_employee' />
                        <button class="rounded-r-full btn join-item">Search</button>
                    </div>
                </div>
                <div class="h-60">
                    <ul>
                        @if ($this->getEmployees)
                            @forelse ($this->getEmployees as $employee)
                                <li class="p-1 mt-2 rounded-md cursor-pointer bg-stone-300 hover:bg-stone-400"
                                    wire:click='selectedEmployee({{ $employee->emp_id }})'>
                                    {{ $employee->lastname }},
                                    {{ $employee->firstname }}
                                </li>
                            @empty
                            @endforelse
                        @endif
                    </ul>
                </div>
                <div class="mt-2">
                    @if ($this->getEmployees != null)
                        {{ $this->getEmployees->links() }}
                    @endif
                </div>
                <div>

                </div>
                <div class="modal-action">
                    <label for="addUser" class="btn btn-sm">Close!</label>
                </div>
            </div>
        </div><!-- Add user end-->


    </div><!----->

</div>
