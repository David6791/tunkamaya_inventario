<div class="modal fade" id="modalAddCar" tabindex="-1" role="dialog" aria-labelledby="modalAddCar" aria-hidden="true"
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
                            NOMBRE TIPO:
                        </th>
                        <td>
                            <p>{{ $name }}</p>
                        </td>
                    </tr>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="new_car">Nueva Caracteristica:</label>
                            <input wire:model.lazy="new_car" type="text" class="form-control" required="">
                            @error('new_car')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0)" wire:click.prevent="addNewCar({{ $selected_id }})"
                        class="btn btn-info" data-toggle="tooltip" title data-original-title="Editar Tipo">Guardar</a>
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-secondary close-btn text-info"
                        data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
