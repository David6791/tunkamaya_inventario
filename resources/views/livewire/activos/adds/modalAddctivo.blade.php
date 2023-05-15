<div wire:ignore.self class="modal fade" id="modalAddctivo" tabindex="-1" role="dialog" aria-labelledby="miModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark-color">
                <h6 class="modal-title">
                    <b>{{ $modalTitle }}</b>
                </h6>
                <h6 class="text-center text-warning" wire:loading> Por favor espere.</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="codigo">CODIGO:</label>
                            <input wire:model.lazy="codigo" type="text" class="form-control" required="">
                            @error('codigo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="costo">COSTO:</label>
                            <div class="input-group">
                                <input wire:model.lazy="costo" type="number" class="form-control" required="">
                                <span class="input-group-btn">
                                    <button type="button" class="btn"> <i class="">Bs.</i> </button>
                                </span>
                            </div>
                            @error('costo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_registro">FECHA ADQUISICIÓN:</label>
                            <input wire:model.lazy="fecha_registro" type="date" class="form-control" required="">
                            @error('fecha_registro')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">DESCRIPCION:</label>
                            <textarea wire:model.lazy="description" rows="7" class="form-control"
                                placeholder="Ingrese Nombre y detalles del Activo" data-dl-input-translation="true"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="Save()"
                        class="btn btn-success close-modal">Guardar</button>
                @else
                    <button type="button" wire:click.prevent="Update()"
                        class="btn btn-primary close-modal">Actualizar</button>
                @endif
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-secondary close-btn text-info"
                    data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
