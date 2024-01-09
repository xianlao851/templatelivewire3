<div class="mt-4">
    <div class="flex flex-col max-w-6xl p-1 mx-auto bg-white rounded-md ">
        <div class="relative h-12 border-b-2">
            <div class="absolute left-0 top-3">
                <h3 class="mx-1">Admin Dashboard</h3>
            </div>
            <div class="absolute right-0 top-2">
                {{-- <label class="bg-gray-300 btn btn-sm hover:bg-gray-400" wire:click='openDiv'> <i
                        class="las la-plus-circle la-2x"></i></label> --}}
                <label class="bg-gray-300 btn btn-sm hover:bg-gray-400" for="addUser"> <i
                        class="las la-plus-circle la-2x"></i></label>
            </div>
        </div>

        @if ($showDiv)
            <div class="grid grid-cols-2 p-4 mt-2">
                <div class="mt-2">
                    <div class="join">
                        <h3 class="text-gray-700 join-item font-base">Name:&nbsp; </h3>
                        <p class="underline join-item">
                            @if ($this->selectedEmployees)
                                {{ $this->selectedEmployees->lastname }}, {{ $selectedEmployees->firstname }}
                            @endif
                        </p>
                    </div>
                    @if ($this->selectedEmployees)
                        <div class="mt-2">
                            <label for="role" class="block mb-2 text-sm text-gray-700 font-base">ROLE
                                <span class="text-red-500">
                                    @error('role')
                                        {{ $message }}
                                    @enderror
                                </span>

                            </label>
                            <select wire:model='role'
                                class="w-full max-w-xs text-xs border-gray-700 select select-bordered select-sm"
                                id="role">
                                <option>ROLE</option>
                                <option value="admin">ADMIN</option>
                                <option value="doctor">DOCTOR</option>
                                <option value="nurse">NURSE</option>
                                <option value="user">USER</option>
                            </select>
                        </div>
                        <div class="mt-6">
                            <button wire:click='createUser'
                                class="btn btn-outline btn-xs hover:bg-gray-200">SAVE</button>
                        </div>
                    @endif
                </div>

                <div>
                    <div class="mt-2">
                        <div class="w-full join">
                            <input class="border-gray-700 w-96 input input-sm input-bordered join-item"
                                placeholder="Search..." wire:model.change='search_employee' />
                            <button class="rounded-r-full btn btn-sm join-item">Search</button>
                        </div>
                    </div>

                    <div class="h-64 w-96">
                        <ul class="">
                            @if ($this->getEmployees)
                                @forelse ($this->getEmployees as $employee)
                                    <li class="p-1 mt-2 rounded-md cursor-pointer bg-stone-300 hover:bg-stone-400"
                                        wire:key='$employee-{{ $employee->emp_id }}'
                                        wire:click='selectedEmployee({{ $employee->emp_id }})'>
                                        {{ $employee->lastname }},
                                        {{ $employee->firstname }}
                                    </li>
                                @empty
                                    No records
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
            </div>
        @endif

        <div class="">
            <div class="overflow-x-auto">
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="uppercase">{{ $user->name }}</td>
                                <td class="uppercase">{{ $user->email }}</td>
                                <td class="text-green-500 uppercase">Empty</td>
                                <td class="uppercase">
                                    <label class="btn btn-xs btn-primary" wire:key="$user-{{ $user->id }}"
                                        wire:click="viewRole({{ $user->id }})" for="view_role">ROLES</label>
                                    <label class="btn btn-xs btn-success">PERMISSION</label>
                                    <label class="btn btn-xs btn-accent">DELETE</label>
                                </td>
                            @empty
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal-->

        <input type="checkbox" id="addUser" class="modal-toggle" /> <!-- Add user-->
        <div class="modal" role="dialog">
            <div class="max-w-4xl modal-box">
                <div class="grid grid-cols-2 p-4 mt-2">
                    <div class="mt-2">
                        <div class="join">
                            <h3 class="text-gray-700 join-item font-base">Name:&nbsp; </h3>
                            <p class="underline join-item">
                                @if ($this->selectedEmployees)
                                    {{ $this->selectedEmployees->lastname }}, {{ $selectedEmployees->firstname }}
                                @endif
                            </p>
                        </div>
                        @if ($this->selectedEmployees)
                            <div class="mt-2">
                                <label for="role" class="block mb-2 text-sm text-gray-700 font-base">ROLE
                                    <span class="text-red-500">
                                        @error('role')
                                            {{ $message }}
                                        @enderror
                                    </span>

                                </label>
                                <select wire:model='role'
                                    class="w-full max-w-xs text-xs border-gray-700 select select-bordered select-sm"
                                    id="role">
                                    <option>ROLE</option>
                                    <option value="admin">ADMIN</option>
                                    <option value="doctor">DOCTOR</option>
                                    <option value="nurse">NURSE</option>
                                    <option value="user">USER</option>
                                </select>
                            </div>
                            <div class="mt-6">
                                <button wire:click='createUser'
                                    class="btn btn-outline btn-xs hover:bg-gray-200">SAVE</button>
                            </div>
                        @endif
                    </div>

                    <div>
                        <div class="mt-2">
                            <div class="w-full join">
                                <input class="border-gray-700 w-96 input input-sm input-bordered join-item"
                                    placeholder="Search..." wire:model.change='search_employee' />
                                <button class="rounded-r-full btn btn-sm join-item">Search</button>
                            </div>
                        </div>

                        <div class="h-64 w-96">
                            <ul class="">
                                @if ($this->getEmployees)
                                    @forelse ($this->getEmployees as $employee)
                                        <li class="p-1 mt-2 rounded-md cursor-pointer bg-stone-300 hover:bg-stone-400"
                                            wire:key='$employee-{{ $employee->emp_id }}'
                                            wire:click='selectedEmployee({{ $employee->emp_id }})'>
                                            {{ $employee->lastname }},
                                            {{ $employee->firstname }}
                                        </li>
                                    @empty
                                        No records
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
                </div>
                <div class="modal-action">
                    <label for="addUser" class="btn btn-sm" wire:click='reset_values'>Close!</label>
                </div>
            </div>
        </div><!-- Add user end-->

        <!-- view roles-->
        <input type="checkbox" id="view_role" class="modal-toggle" />
        <div class="modal" role="dialog">
            <div class="max-w-2xl modal-box">
                <div class="relative">
                    <div class="join">
                        <h3 class="text-gray-700 join-item font-base">Name:&nbsp; </h3>
                        <p class="underline uppercase join-item">
                            @if ($this->getUser)
                                {{ $this->getUser->name }}
                            @endif
                        </p>
                    </div>
                    <div class="absolute top-0 right-0"><label class="mr-1 join-item">ROLES</label>
                    </div>
                </div>
                <div class="mt-1 border-b-2"></div>
                <div class="relative mt-2">
                    <div class="overflow-x-auto">
                        <table class="table table-xs w-60">
                            <thead>
                                <tr>
                                    <th>ROLEs</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($this->getUserRoles)
                                    @forelse ($this->getUserRoles as $userRole)
                                        <tr>
                                            <td> {{ $userRole->name }}</td>
                                            <td>
                                                <label class="btn btn-warning btn-xs"
                                                    wire:key='$userRole-{{ $userRole->id }}'
                                                    wire:click="revokeRole('{{ $userRole->name }}')">REVOKE
                                                </label>
                                            </td>
                                        @empty
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="absolute top-0 right-0 join">
                        <div class="join">
                            <select type="text" id="role"
                                class="text-sm w-[210px] input input-sm input-bordered join-item" wire:model='role'>
                                <option class="uppercase">SELECT ROLE</option>
                                @if ($this->roles)
                                    @forelse ($this->roles as $role)
                                        <option value="{{ $role->name }}"> {{ $role->name }}</option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                            <button class="rounded-r-full btn btn-sm btn-success join-item" wire:click='createRole'><i
                                    class="las la-plus la-2x"></i></button>
                        </div>
                    </div>
                </div> <!-- table-->
                <div class="modal-action">
                    <label for="view_role" class="btn btn-sm">Close!</label>
                </div>
            </div>
        </div><!-- view roles end-->
    </div><!----->

</div>
