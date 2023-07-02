<div wire:ignore.self class="modal fade" id="modalResponsables" tabindex="-1" role="dialog" aria-labelledby="miModalLabel"
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="institucion_id">SELECCIONE LA INSTITUCION:</label>
                            <select wire:model.lazy="institucion_id" class="form-control" name="institucion_id">
                                <option value="Elegir">Elegir</option>
                                @foreach ($instituciones as $i)
                                    <option value="{{ $i->id }}">{{ $i->nombre }}</option>
                                @endforeach
                            </select>
                            @error('institucion_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ci">CEDULA DE IDENTIDAD:</label>
                            <input wire:model.lazy="ci" type="text" class="form-control" required="">
                            @error('ci')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombres">NOMBRES:</label>
                            <input wire:model.lazy="nombres" type="text" class="form-control" required="">
                            @error('nombres')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apellidos">APELLIDOS:</label>
                            <input wire:model.lazy="apellidos" type="text" class="form-control" required="">
                            @error('apellidos')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">ESTADO:</label>
                            <select wire:model.lazy="status" class="form-control" name="status">
                                <option value="Elegir">Elegir</option>
                                <option value="1">ACTIVO</option>
                                <option value="0">BLOQUEADO</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cargo">CARGO:</label>
                            <input wire:model.lazy="cargo" type="text" class="form-control" required="">
                            @error('cargo')
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
