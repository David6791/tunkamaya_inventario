<div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Listado |<small>Activos</small></h2>
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
                <table class="table table-bordered table-striped mt-1 tchna">
                    <thead class="text-white" style="background: #003471">
                        <tr>
                            <th class="table-th text-white">NRO.</th>
                            <th class="table-th text-white text-center">CODIGO</th>
                            <th class="table-th text-white text-center">DESCRIPCION</th>
                            <th class="table-th text-white text-center">ACCION </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $r)
                            <tr>
                                <td>{{ $r->id }}</td>
                                <td>{{ $r->codigo }}</td>
                                <td>{{ $r->description }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click="Show({{ $r->id }})"
                                        class="btn btn-primary btn-sm" title="Ver detalles">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="javascript:void(0)" wire:click="Edit({{ $r->id }})"
                                        class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fa fa-edit"></i>
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
                    <a class="btn btn-success" href="javascript:void(0)" wire:click="addNweActivo()">Agregar
                        Activo Nuevo</a>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.activos.adds.modalShowActivo')
    @include('livewire.activos.adds.modalAddctivo')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //para escuchar eventos
            window.livewire.on('modalShowActivo', msg => {
                $('#modalUser').modal('show');
            });
            window.livewire.on('modalAddctivo', msg => {
                $('#modalAddctivo').modal('show');
            });
            window.livewire.on('modalAddctivoClose', msg => {
                $('#modalAddctivoClose').modal('close');
            });

            window.livewire.on('hide-modal', msg => {
                $('#theModal').modal('hide');
            });
            window.livewire.on('successDelete', msg => {
                Swal.fire({
                    icon: 'success',
                    title: msg
                })
            });
            window.livewire.on('errorDelete', msg => {
                Swal.fire({
                    icon: 'error',
                    title: msg
                })
            });

            window.livewire.on('activo_register', msg => {
                Swal.fire(
                    'Correcto',
                    msg,
                    'success'
                )
                $('#modalAddctivo').modal('hide');
            });
            $('#theModal').on('hidden.bs.modal', msg => {
                $('.er').css('display', 'none')
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
                    window.livewire.emit('DeleteActivo', id);
                    swal.close();
                }
            });
        }
    </script>
</div>
