<div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Listado |<small>Permisos para Usuarios</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <a class=""><i class="fa fa-wrench"></i></a>
                </li>
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="widget-content">
                <div class="form-inline">
                    <div class="form-group mr-5">
                        <select wire:model="role" class="form-control">
                            <option value="Elegir" selected>Selecciona un Rol</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button wire:click.prevent="SyncAll()" type="button"
                        class=" btn btn-sm btn-success mbmobile inblock mr-5">Asignar Todos</button>
                    <button onclick="Revocar()" type="button" class=" btn btn-danger btn-sm mbmobile mr-5">Rebocar
                        Todos</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mt-1">
                    <thead class="text-white" style="background: #003471">
                        <tr>
                            <th class="table-th text-white">ID</th>
                            <th class="table-th text-white">PERMISO</th>
                            <th class="table-th text-white">ROLES CON EL PERMISO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permisos as $permiso)
                            <tr>
                                <td>
                                    <h6 class="text-center">{{ $permiso->id }} </h6>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox"
                                            wire:change="SyncPermiso($('#p' + {{ $permiso->id }}).is(':checked'), '{{ $permiso->name }}' )"
                                            id="p{{ $permiso->id }}" value="{{ $permiso->id }}"
                                            class="form-check-input" {{ $permiso->checked == 1 ? 'checked' : '' }}>
                                        <label for="staticEmail2" class="checkbox-primary form-check-label">
                                            <h6>{{ $permiso->name }}</h6>
                                        </label>
                                        <span class="new-control-indicator"></span>
                                    </div>
                                </td>
                                <td>
                                    <h6>{{ \App\Models\User::permission($permiso->name)->count() }}</h6>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $permisos->links() }}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //para escuchar eventos~            
            window.livewire.on('Sync-error', Msg => {
                Toast.fire({
                    icon: 'success',
                    title: Msg
                })
            })
            window.livewire.on('permi', Msg => {
                Toast.fire({
                    icon: 'success',
                    title: Msg
                })
            })
            window.livewire.on('syncall', Msg => {
                Toast.fire({
                    icon: 'success',
                    title: Msg
                })
            })
            window.livewire.on('removeall', Msg => {
                Toast.fire({
                    icon: 'success',
                    title: Msg
                })
            })
        });

        function Revocar(id, products) {
            Swal.fire({
                title: 'Confirmar',
                text: 'Confirmas Eliminar todos los Permisos',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'CERRAR',
                CancelButtonColor: '#fff',
                confirmButtonColor: '#3b3f5c',
                confirmButtonText: 'Aceptar'
            }).then(function(result) {
                if (result.value) {
                    window.livewire.emit('revokeall', id);
                    swal.close();
                }
            });
        }
    </script>
</div>
