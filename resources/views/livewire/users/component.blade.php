<div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Listado |<small>Usuarios</small></h2>
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
                            <th class="table-th text-white">USUARIO</th>
                            <th class="table-th text-white text-center">TELEFONO</th>
                            <th class="table-th text-white text-center">EMAIL</th>
                            <th class="table-th text-white text-center">TIPO USUARIO</th>
                            <th class="table-th text-white text-center">STATUS</th>
                            <th class="table-th text-white text-center">IMAGEN</th>
                            <th class="table-th text-white text-center">ACCION </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $r)
                            <tr>
                                <td>{{ $r->name }}</td>
                                <td>{{ $r->phone }}</td>
                                <td>{{ $r->email }}</td>
                                <td>{{ $r->profile }}</td>
                                <td>
                                    <span
                                        class="badge {{ $r->status === 'ACTIVO' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $r->status }}</span>
                                </td>
                                <td class="text-center">
                                    @if ($r->image != null)
                                        <img src="{{ asset('storage/usuarios/' . $r->image) }}" alt=""
                                            class="profile_img" width="40" height="40">
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click="Edit({{ $r->id }})"
                                        class="btn btn-info btn-sm" title="Editar">
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
                    <a class="btn btn-success" href="javascript:void(0)" role="button" data-toggle="modal"
                        data-target="#modalUser">Registrar Nuevo Usuario</a>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.users.form')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //para escuchar eventos
            window.livewire.on('modalUser', msg => {
                $('#modalUser').modal('show');
            });
            window.livewire.on('hide-modal', msg => {
                $('#theModal').modal('hide');
            });
            window.livewire.on('profile_update', msg => {
                Toast.fire({
                    icon: 'success',
                    title: msg
                })
            });
            window.livewire.on('deleteError', msg => {
                Toast.fire({
                    icon: 'error',
                    title: msg
                })
            });
            window.livewire.on('user-deleted', msg => {
                Toast.fire({
                    icon: 'success',
                    title: msg
                })
            });
            window.livewire.on('profile_success', msg => {
                Swal.fire(
                    'Correcto',
                    msg,
                    'success'
                )
                $('#theModal').modal('hide');
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
                    window.livewire.emit('DeleteUser', id);
                    swal.close();
                }
            });
        }
    </script>
</div>
