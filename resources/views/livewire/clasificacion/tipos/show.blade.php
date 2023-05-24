<div class="modal fade" id="modalShowTipo" tabindex="-1" role="dialog" aria-labelledby="modalShowTipo" aria-hidden="true"
    data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="">{{ $modalTitle }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>
                            GRUPO CONTABLE:
                        </th>
                        <td colspan="3">
                            <p>{{ $nombre_grupo }}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            NOMBRE TIPO:
                        </th>
                        <td colspan="3">
                            <p>{{ $name }}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>CODIGO:</th>
                        <td>{{ $codigo }}</td>
                        <th>ESTADO:</th>
                        <td>{{ $status === 0 ? 'Bloqueado' : 'Activo' }}</td>
                    </tr>
                </table>
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">Nro. </th>
                            <th class="column-title">Caractersitica </th>
                            <th class="column-title">Opcion </th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count($caracetristicas); $i++)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $caracetristicas[$i] }}</td>
                                <td><a href="javascript:void(0)"
                                        onclick="ConfirmDeleteC('{{ $selected_id }}','{{ $i }}')"
                                        class="btn btn-danger btn-sm" data-toggle="tooltip" title
                                        data-original-title="Eliminar Tipo">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" wire:click.prevent="addCar({{ $selected_id }})"
                    class="btn btn-info btn-block" data-toggle="tooltip">Agregar Nueva Caractersitica</a>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-secondary close-btn text-info"
                    data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
