<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Roles del usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <p class="h5">Nombre:</p>
                        <p class="form-control">{{$user->name}}</p>
                        <h2 class="h5">Lista de roles</h2>
                        @foreach ($roles as $role )
                        <div>
                            <label for="role">
                                <input type="checkbox" name="role" id="role" wire:model="roles">{{$role->name}}
                            </label>
                        </div>
                        @endforeach
                        @error('role') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="update()" class="btn btn-primary"
                        data-dismiss="modal">Cambiar role</button>
                </div>
            </div>
        </div>
    </div>
</div>
