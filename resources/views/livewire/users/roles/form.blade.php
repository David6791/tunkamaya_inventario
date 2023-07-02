<div wire:ignore.self class="modal fade" id="modalRoles" tabindex="-1" role="dialog" aria-labelledby="miModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark-color">
                <h6 class="modal-title">
                    <b>{{ $modalTitle }}</b>
                </h6>
                <span class="spinner-border spinner-border-sm spinner-border-custom" wire:loading></span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">NOMBRE ROL:</label>
                            <input wire:model.lazy="name" type="text" class="form-control" required=""
                                placeholder="">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="guard_name">DESCRIPCION:</label>
                            <input wire:model.lazy="guard_name" type="text" class="form-control" required=""
                                placeholder="">
                            @error('guard_name')
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
