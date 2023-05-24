<div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Listado |<small> SubTipos</small></h2>
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
                            <th class="table-th text-white text-center">NOMBRE SUBTIPO</th>
                            <th class="table-th text-white text-center">TIPO</th>
                            <th class="table-th text-white text-center">STATUS</th>
                            <th class="table-th text-white text-center">ACCION </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5">
                                <h2 class="red">Si es necesario se puede aumentar</h2>
                            </td>
                        </tr>
                        @foreach ($data as $r)
                            <tr>
                                <td>{{ $r->codigo }}</td>
                                <td>{{ $r->name }}</td>
                                <td>{{ $r->tipo_name }}</td>
                                <td>
                                    <span
                                        class="badge {{ $r->status === 1 ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $r->status === 1 ? 'ACTIVO' : 'BLOQUEADO' }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click="Show({{ $r->id }})"
                                        class="btn btn-success btn-sm" data-toggle="tooltip" title
                                        data-original-title="Ver Tipo">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="javascript:void(0)" wire:click="Edit({{ $r->id }})"
                                        class="btn btn-info btn-sm" data-toggle="tooltip" title
                                        data-original-title="Editar Tipo">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="Confirm('{{ $r->id }}')"
                                        class="btn btn-danger btn-sm" data-toggle="tooltip" title
                                        data-original-title="Eliminar Tipo">
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
                        data-target="#modalTipos">Registrar Nuevo Tipo</a>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.clasificacion.tipos.form')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            window.livewire.on('deleted', msg => {
                Swal.fire(
                    'Correcto',
                    msg,
                    'success'
                )
                $('#modalTipos').modal('hide');
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
                cancelButtonText: 'Cerrar',
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
