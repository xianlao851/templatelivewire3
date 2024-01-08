<div>
    <div class="max-w-6xl p-2 mx-auto mt-8 bg-white">
        <div class="relative mx-2">
            <div class="absolute">
                <h4>Roles</h4>
            </div>
            <div class="absolute top-0 right-0"> <label class="bg-gray-400 btn btn-xs" for="create_role"> Create</label>
            </div>
        </div>
        <div class="mt-8 overflow-x-auto border-t-2">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="uppercase">
                        <th></th>
                        <th>role</th>
                        <th>action</th>

                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    @forelse ($this->roles as $role)
                        <tr class="uppercase">
                            <td></td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <label class="btn btn-xs btn-neutral" wire:key='$role-{{ $role->id }}'
                                    wire:click="editRole('{{ $role->id }}','{{ $role->name }}')"
                                    for="edit_role">EDIT</label>
                                <label class="btn btn-xs btn-warning" wire:key='$role-{{ $role->id }}'
                                    wire:click='delete({{ $role->id }})'>DELETE</label>

                            <td></td>
                        @empty
                            <td>Empty</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!--Modals-->

        <!-- create role -->
        <input type="checkbox" id="create_role" class="modal-toggle" />
        <div class="modal" role="dialog">
            <div class="modal-box max-w-96">
                <div class="border-b-2">
                    <h3 class="text-lg font-bold">Create Role</h3>
                </div>

                <div class="mt-2">
                    <label for="role" class="block mb-2 text-sm text-gray-700 font-base">ROLE
                        <span class="text-red-500">
                            @error('role')
                                {{ $message }}
                            @enderror
                        </span>
                    </label>
                    <input type="text" wire:model='role' placeholder="Role ..." id="role"
                        class="w-full max-w-xs input input-sm input-bordered" />
                </div>
                <div class="modal-action">
                    <label class="btn btn-sm btn-success" for="create_role" wire:click='createUser'>Save</label>
                    <label for="create_role" class="btn btn-sm">Close!</label>
                </div>
            </div>
        </div> <!-- create role end-->

        <input type="checkbox" id="edit_role" class="modal-toggle" /> <!-- Edit role-->
        <div class="modal" role="dialog">
            <div class="modal-box max-w-96">
                {{-- <div class="border-b-2">
                        <h3 class="text-lg font-bold">Edit Role</h3>
                    </div> --}}
                <div class="mt-2">
                    <label for="role" class="block mb-2 text-sm text-gray-700 font-base">ROLE
                    </label>
                    <input type="text" value="{{ $this->role }}" id="role"
                        class="w-full max-w-xs input input-sm input-bordered" wire:model="role" />
                </div>
                <div class="modal-action">
                    <label class="btn btn-sm btn-success" for="edit_role" wire:click='updateRole'>Save</label>
                    <label for="edit_role" class="btn btn-sm">Close!</label>
                </div>
            </div>
        </div>
        <!--Modals-->
    </div>
    <script>
        window.addEventListener('updated', function() {
            Swal.fire({
                title: "Successful",
                text: "Data has been updated",
                icon: "success",
                confirmButtonColor: "#a6a4a4",
            });
        });
    </script>
</div>
