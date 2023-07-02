<div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Detalles |<small>INSTITUCION</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <a class=""><i class="fa fa-wrench"></i></a>
                </li>
                <li>
                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-md-3 col-sm-3  profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <img data-action='zoom' class="img-responsive avatar-view"
                                src="{{ asset('storage/instituciones/' . $data->image) }}" alt="Avatar"
                                title="Change the avatar" width="220">
                        </div>
                    </div>
                    <hr>
                    <ul class="list-unstyled user_data">
                        <li>
                            <i class="fa fa-square-o user-profile-icon"></i>
                            {{ $data->codigo_id . ', ' . $data->nombre }}
                        </li>
                    </ul>
                    <hr>
                    <button wire:click.prevent="Edit({{ $data->id }})" type="button"
                        class="btn btn-success text-white btn-block"><i class="fa fa-edit m-right-xs"></i> Editar
                        Institucion</button>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="codigo_id">Codigo Institucion:</label>
                                <input disabled type="text" id="codigo_id" class="form-control" name="codigo_id"
                                    required="" value="{{ $data->codigo_id }}">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="nombre">Nombres:</label>
                                <input disabled type="text" id="nombre" class="form-control" required=""
                                    value="{{ $data->nombre }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contacto">Contacto:</label>
                                <input disabled type="text" id="contacto" class="form-control" required=""
                                    value="{{ $data->contacto }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="responsable">Responsable:</label>
                                <input disabled type="text" id="responsable" class="form-control" required=""
                                    value="{{ $data->responsable }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="direccion">Direccion:</label>
                                <input disabled type="text" id="direccion" class="form-control" required=""
                                    value="{{ $data->direccion }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Correo Electronico:</label>
                                <input disabled type="text" id="email" class="form-control" required=""
                                    value="{{ $data->email }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefono">Telefono:</label>
                                <input disabled type="text" id="telefono" class="form-control" required=""
                                    value="{{ $data->telefono }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ubicaion">Ubicado en:</label>
                                <input disabled type="text" id="ubicaion" class="form-control" required=""
                                    value="{{ $data->ubicacion->localidad }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_registro">Fecha de Registro:</label>
                                <input disabled type="text" id="fecha_registro" class="form-control"
                                    required="" value="{{ $data->fecha_registro }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="registrador">Registrado por:</label>
                                <input disabled type="text" id="registrador" class="form-control" required=""
                                    value="{{ $data->usuario }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Lista |<small>Usuarios Asignados</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class=""><i class="fa fa-wrench"></i></a>
                        </li>
                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombres y Apellidos</th>
                                <th>Fecha Asignacion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asignados as $i)
                                <tr>
                                    <td>{{ $i->usuario }}</td>
                                    <td>{{ $i->fecha_registro }}</td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $i->id }}')"
                                            class="btn btn-danger btn-sm" title="Borrar Designacion">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    <button class="btn btn-success" wire:click="asigUsuarios('{{ $data->id }}')"> <i
                            class="fa fa-plus"></i> Asignar Nuevo</button>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Detalle |<small>Codificacion</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class=""><i class="fa fa-wrench"></i></a>
                        </li>
                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if ($form === false)
                        <div class="row">
                            <div class="col-md-6">
                                @foreach ($data->ejemplo_codificacion as $i)
                                    {{ $i }}
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-info btn-sm"
                                    wire:click="editFormatCod('{{ $data->id }}')"> <i class="fa fa-edit"></i>
                                    Editar Formato de
                                    Codigo</button>
                            </div>

                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-5">
                                Vista Previa de la Codificacion
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" wire:model.lazy="preview">
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                Datos para la Codificacion
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <button class="btn btn-info btn-sm btn-block" type="button"
                                    wire:click="addInput('{{ $data->id . '_' . 'in' }}')" title="Cod. Institucion">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-info btn-sm btn-block" type="button"
                                    wire:click="addInput('{{ $data->id . '_' . 'gc' }}')"
                                    title="Cod. Grupo Contable">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-info btn-sm btn-block" type="button"
                                    wire:click="addInput('{{ $data->id . '_' . 'ta' }}')" title="Cod. Tipo Activo">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success btn-sm btn-block" type="button"
                                    wire:click="addInput('{{ $data->id . '_' . 'a' }}')" title="Campo Editable">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-danger btn-block btn-sm" type="button"
                                    wire:click="deleteInputs" title="Borrar todo"><i
                                        class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                @foreach ($inputs as $key => $value)
                                    <div class="item form-group has-feedback">
                                        <label class="col-form-label col-md-4 col-sm-4"
                                            for="first-name.{{ $key }}">Ingrese el dato -
                                            {{ $key + 1 }}:
                                        </label>
                                        <input type="text" wire:model="inputs.{{ $key }}"
                                            id="myInput.{{ $key }}" size="3"
                                            class="form-control col-form-label col-md-3 col-sm-3"
                                            wire:change="actualizarCodigo($event.target.value)">
                                    </div>
                                @endforeach
                                <div class="row">
                                    @if ($selected_id < 1)
                                        <div class="col-md-6"> <button class="btn btn-success btn-block btn-sm"
                                                type="button" wire:click.prevent="saveCodigoTipe()"> <i
                                                    class="fa fa-save"></i> Guardar</button>
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <button type="button" wire:click.prevent="updateCodigoTipe()"
                                                class="btn btn-primary btn-block btn-sm close-modal"> <i
                                                    class="fa fa-edit"></i> Actualizar</button>
                                        </div>
                                    @endif

                                    <div class="col-md-6"> <button class="btn btn-danger btn-block btn-sm"
                                            type="button" wire:click.prevent="resetUI()"> <i
                                                class="fa fa-times"></i> Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @include('livewire.instituciones.formAsig')
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('asigUsuarios', msg => {
                $('#modalAsign').modal('show');
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
