<div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Listado |<small>Instituciones</small></h2>
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
                            <th class="table-th text-white">CODIGO</th>
                            <th class="table-th text-white text-center">NOMBRE</th>
                            <th class="table-th text-white text-center">DIRECCION</th>
                            <th class="table-th text-white text-center">EMAIL</th>
                            <th class="table-th text-white text-center">ESTADO</th>
                            <th class="table-th text-white text-center">ACCION </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $r)
                            <tr>
                                <td>{{ $r->codigo_id }}</td>
                                <td>{{ $r->nombre }}</td>
                                <td>{{ $r->direccion }}</td>
                                <td>{{ $r->email }}</td>
                                <td>
                                    <span
                                        class="badge {{ $r->status === 'ACTIVO' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $r->status === 'ACTIVO' ? 'ACTIVO' : 'BLOQUEADO' }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)"
                                        wire:click="detalles_institucion('{{ $r->id }}')"
                                        class="btn btn-info btn-sm" title="Editar">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="Confirm('{{ $r->id }}')"
                                        class="btn btn-danger btn-sm" title="Borrar">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-success" href="javascript:void(0)" role="button" data-toggle="modal"
                        data-target="#modalInstitu">Registrar Nueva Institucion</a>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.instituciones.form')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            window.livewire.on('deleted', msg => {
                Swal.fire(
                    'Correcto',
                    msg,
                    'success'
                )
                $('#modalDepartamento').modal('hide');
            });
            window.livewire.on('errorDelete', msg => {
                Swal.fire(
                    'Error',
                    msg,
                    'error'
                )
                $('#modalDepartamento').modal('hide');
            });
            window.livewire.on('registrado', msg => {
                Swal.fire(
                    'Correcto',
                    msg,
                    'success'
                )
                $('#modalDepartamento').modal('hide');
            });
            window.livewire.on('updated', msg => {
                Swal.fire(
                    'Correcto',
                    msg,
                    'success'
                )
                $('#modalDepartamento').modal('hide');
            });
            window.livewire.on('edit', msg => {
                $('#modalDepartamento').modal('show');
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
                    window.livewire.emit('Delete', id);
                    swal.close();
                }
            });
        }
    </script>
</div>
