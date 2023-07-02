<div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Listado |<small>Usuarios con sus Roles</small></h2>
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
            @include('common.searchbox')
            <div class="table-responsive">
                <table class="table table-bordered table-striped mt-1">
                    <thead class="text-white" style="background: #003471">
                        <tr>
                            <th class="table-th text-white">CEDULA DE IDENTIDAD</th>
                            <th class="table-th text-white">NOMBRE USUARIO</th>
                            <th class="table-th text-white text-center">ROL ASIGNADO</th>
                            <th class="table-th text-white text-center">FECHA ASIGNACION</th>
                            <th class="table-th text-white text-center">ACCION </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $r)
                            <tr>
                                <td>{{ $r->cedula_identidad }}</td>
                                <td>{{ $r->name . ' ' . $r->surname }}</td>
                                <td>{{ $r->role_name }}</td>
                                <td></td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click="Edit({{ $r->id }})"
                                        class="btn btn-info btn-sm" title="Editar Rol">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
        </div>
    </div>
    @include('livewire.users.asignarroles.form')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //para escuchar eventos~            
            window.livewire.on('success', msg => {
                Swal.fire({
                    title: 'Correcto',
                    text: msg,
                    icon: 'success',
                })
                $('#modalAsignarRol').modal('hide');
            });
            window.livewire.on('error', msg => {
                Swal.fire({
                    title: 'Error',
                    text: msg,
                    icon: 'error',
                })
                $('#modalPermiso').modal('hide');
            });
            window.livewire.on('show-modal', msg => {
                $('#modalAsignarRol').modal('show');
            });
        });

        function Confirm(id, products) {
            if (products > 0) {
                Swal.fire('NO SE PUEDE ELIMINAR LA CATEGORIA PORQUE TIENE PRODUCTOS RELACIONADOS')
                return;
            }
            Swal.fire({
                title: 'Confirmar',
                text: 'Confirmas Eliminar el Registro',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'CERRAR',
                CancelButtonColor: '#fff',
                confirmButtonColor: '#3b3f5c',
                confirmButtonText: 'Aceptar'
            }).then(function(result) {
                if (result.value) {
                    window.livewire.emit('DeletePermiso', id);
                    swal.close();
                }
            });
        }
    </script>
</div>
