<div wire:ignore.self class="modal fade" id="modalInstitu" tabindex="-1" role="dialog" aria-labelledby="miModalLabel"
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
                            <select wire:model.lazy="departamento_id" wire:change="select_depart($event.target.value)"
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
                            <select wire:model.lazy="provincia_id" wire:change="select_prov($event.target.value)"
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
                            <select wire:model.lazy="municipio_id" wire:change="select_muni($event.target.value)"
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="codigo_id">CODIGO INSTITUCION:</label>
                            <input wire:model.lazy="codigo_id" type="text" class="form-control" required=""
                                placeholder="">
                            @error('codigo_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="nombre">NOMBRE INSTITUCION:</label>
                            <input wire:model.lazy="nombre" type="text" class="form-control" required=""
                                placeholder="">
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="responsable">DATOS RESPONSABLE:</label>
                            <input wire:model.lazy="responsable" type="text" class="form-control" required=""
                                placeholder="">
                            @error('responsable')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contacto">DATOS CONTACTO:</label>
                            <input wire:model.lazy="contacto" type="text" class="form-control" required=""
                                placeholder="">
                            @error('contacto')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="direccion">DIRECCION:</label>
                            <input wire:model.lazy="direccion" type="text" class="form-control" required=""
                                placeholder="">
                            @error('direccion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">CORREO ELECTRONICO:</label>
                            <input wire:model.lazy="email" type="text" class="form-control" required=""
                                placeholder="">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="telefono">TELEFONO:</label>
                            <input wire:model.lazy="telefono" type="text" class="form-control" required=""
                                placeholder="">
                            @error('telefono')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">ESTADO:</label>
                            <select wire:model.lazy="status" class="form-control" name="status">
                                <option value="Elegir">Elegir</option>
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="BLOQUEADO">BLOQUEADO</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label">LOGO INSTITUCION</label>
                            <input type="file" wire:model.lazy="image" accept="image/x-png,image/jpeg,image/jpg"
                                class="form-control">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div wire:loading wire:target="image">Uploading...</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" id="avatar">
                            <center>
                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}" alt="" width="100"
                                        height="100" data-action='zoom' class="img-circle">
                                @else
                                    <img data-action='zoom' class="img-responsive img-circle" width="100"
                                        height="100" src="{{ asset('img/noimage.png') }}" alt="">
                                @endif
                            </center>
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
