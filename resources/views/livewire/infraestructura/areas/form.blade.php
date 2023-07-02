<div wire:ignore.self class="modal fade" id="modalAreas" tabindex="-1" role="dialog" aria-labelledby="miModalLabel"
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
                            <label for="institucion_id">INSTITUCIONES:</label>
                            <select wire:model.lazy="institucion_id" wire:change="select_bloques($event.target.value)"
                                class="form-control" name="institucion_id">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bloque_id">BLOQUES:</label>
                            <select wire:model.lazy="bloque_id" class="form-control" name="bloque_id">
                                <option value="Elegir">Elegir</option>
                                @forelse ($bloques as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('bloque_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="responsable_id">RESPONSABLE:</label>
                            <select wire:model.lazy="responsable_id" class="form-control" name="responsable_id">
                                <option value="Elegir">Elegir</option>
                                @foreach ($responsables as $r)
                                    <option value="{{ $r->id }}">
                                        {{ $r->nombres . ' ' . $r->apellidos . ' - ' . $r->cargo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('responsable_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="codigo">CODIGO:</label>
                            <input wire:model.lazy="codigo" type="text" class="form-control" required="">
                            @error('codigo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">NOMBRE AREA:</label>
                            <input wire:model.lazy="name" type="text" class="form-control" required="">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
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
