<div>
    <div>
        <div>
            <div class="card">
                <div class="card-header">
                    <input type="text" class="form-control" placeholder="Ingreso el nombre o email del usuario"
                        wire:model="search">
                </div>
                <div class="card-body">
                    <h4 class="card-title">Lista de Usuarios</h4>
                    <table class="table table-striped">
                        <thead class="thead-inverse">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td width='10px'>
                                        <a href="{{ route('roleUser.edit', $user) }}"
                                            class="btn btn-primary">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
