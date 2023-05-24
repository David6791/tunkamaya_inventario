<div wire:ignore.self class="modal fade" id="modalDepartamento" tabindex="-1" role="dialog" aria-labelledby="miModalLabel"
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
                            <label for="departamento_id">DEPARTAMENTO:</label>
                            <select wire:model.lazy="departamento_id" wire:click="select_depart($event.target.value)"
                                class="form-control" name="departamento_id">
                                <option value="Elegir">Elegir</option>
                                @foreach ($departamentos as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @endforeach
                            </select>
                            @error('departamento_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="provincia_id">PROVINCIA:</label>
                            <select wire:model.lazy="provincia_id" wire:click="select_prov($event.target.value)"
                                class="form-control" name="provincia_id">
                                <option value="Elegir">Elegir</option>
                                @forelse ($provincias as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('provincia_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="municipio_id">MUNICIPIO:</label>
                            <select wire:model.lazy="municipio_id" wire:click="select_muni($event.target.value)"
                                class="form-control" name="municipio_id">
                                <option value="Elegir">Elegir</option>
                                @forelse ($municipios as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('municipio_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="localidad_id">LOCALIDAD:</label>
                            <select wire:model.lazy="localidad_id" class="form-control" name="localidad_id">
                                <option value="Elegir">Elegir</option>
                                @forelse ($localidades as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('localidad_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="codigo">CODIGO:</label>
                            <input wire:model.lazy="codigo" type="text" class="form-control" required=""
                                placeholder="PT">
                            @error('codigo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">NOMBRE LOCALIDAD:</label>
                            <input wire:model.lazy="name" type="text" class="form-control" required=""
                                placeholder="POTOSI">
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="observation">OBSERVACIONES:</label>
                            <textarea wire:model.lazy="observation" rows="3" class="form-control"
                                placeholder="Registre las observaciones aqui..." data-dl-input-translation="true"></textarea>
                            @error('observation')
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
