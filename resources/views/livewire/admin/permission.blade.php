<div>
    <div class="max-w-6xl p-2 mx-auto mt-8 bg-white">
        <div class="relative">
            <div class="absolute">
                <h4>Permissions</h4>
            </div>
            <div class="absolute top-0 right-0 "> <label class="bg-gray-400 btn btn-xs"
                    for="create_permission">Create</label> </div>
        </div>
        <div class="mt-8 overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="uppercase">
                        <th></th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    @forelse ($this->permissions as $permission)
                        <tr class="uppercase">
                            <td></td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <label class="btn btn-xs btn-neutral" wire:key='$permission-{{ $permission->id }}'
                                    wire:click="editPermission('{{ $permission->id }}','{{ $permission->name }}')"
                                    for="edit_permission">EDIT</label>

                                <label class="btn btn-xs btn-warning" wire:key='$permission-{{ $permission->id }}'
                                    onclick="deletePermission({{ $permission->id }})">DELETE</label>

                                <label class="btn btn-xs btn-success" wire:key='$permission-{{ $permission->id }}'
                                    wire:click="assignRole('{{ $permission->id }}','{{ $permission->name }}')"
                                    for="assign_role">ASSIGN ROLE</label>
                            @empty
                            <td>Empty</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!--Modals-->

        <input type="checkbox" id="create_permission" class="modal-toggle" /> <!--Create permission-->
        <div class="modal" role="dialog">
            <div class="modal-box max-w-96">
                <div class="border-b-2">
                    <h3 class="text-lg font-bold">Create Permission</h3>
                </div>

                <div class="mt-2">
                    <label for="role" class="block mb-2 text-sm text-gray-700 font-base">Permission
                        <span class="text-red-500">
                            @error('role')
                                {{ $message }}
                            @enderror
                        </span>
                    </label>
                    <input type="text" wire:model='permission' placeholder="Role ..." id="role"
                        class="w-full max-w-xs input input-sm input-bordered" />
                </div>
                <div class="modal-action">
                    <label class="btn btn-sm btn-success" for="create_permission"
                        wire:click='createPermission'>Save</label>
                    <label for="create_permission" class="btn btn-sm">Close!</label>
                </div>
            </div>
        </div><!--Create permission-->

        <input type="checkbox" id="edit_permission" class="modal-toggle" /> <!--edit permission-->
        <div class="modal" role="dialog">
            <div class="modal-box max-w-96">
                <div class="border-b-2">
                    <h3 class="text-lg font-bold">Edit Permission</h3>
                </div>
                <div class="mt-2">
                    <label for="permission" class="block mb-2 text-sm text-gray-700 font-base">Permission
                    </label>
                    <input type="text" value="{{ $this->permission }}" id="permission"
                        class="w-full max-w-xs input input-sm input-bordered" wire:model='permission' />
                </div>
                <div class="modal-action">
                    <label class="btn btn-sm btn-success" for="edit_permission"
                        wire:click='updatePermission'>Save</label>
                    <label for="edit_permission" class="btn btn-sm">Close!</label>
                </div>
            </div>
        </div><!--edit permission-->

        <input type="checkbox" id="assign_role" class="modal-toggle" /> <!--assign role-->
        <div class="modal" role="dialog">
            <div class="modal-box max-w-96">
                <div class="join">
                    <h3 class="text-gray-700 join-item font-base">Role:&nbsp; </h3>
                    <p class="underline join-item">
                        @if ($this->getPermission)
                            {{ $this->getPermission->name }}
                        @endif
                    </p>
                </div>
                <div class="mt-2">
                    <label for="permission" class="block mb-2 text-sm text-gray-700 font-base">Permission
                        <span class="text-red-500">
                            @error('role')
                                {{ $message }}
                            @enderror
                        </span>
                    </label>
                    <div class="join">
                        <select type="text" id="role"
                            class="text-sm w-[270px] input input-sm input-bordered join-item" wire:model="role">
                            <option class="uppercase">SELECT ROLE</option>
                            @forelse ($this->roles as $role)
                                <option class="uppercase" value="{{ $role->name }}"> {{ $role->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        <button class="rounded-r-full btn btn-sm btn-success join-item"
                            wire:click='createPermissionRole'><i class="las la-plus la-2x"></i></button>
                    </div>
                </div>
                <div class="mt-2">
                    <h4 class="text-gray-500 border-b-2">Permissions</h4>
                    <div class="overflow-x-auto">
                        <table class="table table-xs">
                            <thead>
                                <tr class="uppercase">
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($this->getPermission)
                                    @forelse ($this->getPermission->roles as $permission_role)
                                        <tr class="uppercase">
                                            <td>{{ $permission_role->name }}</td>
                                            <td><label class="btn btn-xs btn-warning"
                                                    wire:click="revokeRole('{{ $permission_role->name }}')">Revoke</label>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-sm">No permissions</td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-action">
                    <label wire:click='resetValues' for="assign_role" class="btn btn-sm">Close!</label>
                </div>
            </div>
        </div><!--assign role-->

        <!--Modals-->
    </div>

    <script>
        function deletePermission(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#0f7d34",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteComfirmedPermission', {
                        id: id
                    });
                }
            });
        }
        window.addEventListener('updated', function() {
            Swal.fire({
                title: "Successful",
                text: "Data has been updated",
                icon: "success",
                confirmButtonColor: "#a6a4a4",
            });
        });

        window.addEventListener('deleted', function() {
            Swal.fire({
                title: "Successfully deleted",
                text: "Data has been deleted",
                icon: "success",
                confirmButtonColor: "#a6a4a4",
            });
        });
    </script>

</div>
