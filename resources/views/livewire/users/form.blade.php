<div wire:ignore.self class="modal fade" id="modalUser" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark-color">
                <h6 class="modal-title">
                    <b>{{ $modalTitle }}</b>
                </h6>
                <h6 class="text-center text-warning" wire:loading> Por favor espere.</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Nombres:</label>
                            <input wire:model.lazy="name" type="text" class="form-control" required="">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="surname">Apellidos :</label>
                            <input wire:model.lazy="surname" type="text" class="form-control" name="surname"
                                required="">
                            @error('surname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cedula_identidad">Cedula de Identidad :</label>
                            <input wire:model.lazy="cedula_identidad" type="text" class="form-control"
                                name="cedula_identidad" required="">
                            @error('cedula_identidad')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">Correo Electronico:</label>
                            <input wire:model.lazy="email" type="text" class="form-control" name="email"
                                required="">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Celular :</label>
                            <input wire:model.lazy="phone" type="text" class="form-control" name="phone"
                                required="">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Direccion :</label>
                            <input wire:model.lazy="address" type="text" class="form-control" name="address"
                                required="">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Estado Usuario :</label>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="profile">Rol de Usuario :</label>
                            <select wire:model.lazy="profile" class="form-control" name="profile">
                                <option value="Elegir">Elegir</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                            @error('profile')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Imagen de Perfil</label>
                            <input type="file" wire:model.lazy="image" accept="image/x-png,image/jpeg,image/jpg"
                                class="form-control">
                            @error('image')
                                <span class="error">{{ $message }}</span>
                            @enderror
                            <div wire:loading wire:target="image">Uploading...</div>
                        </div>
                    </div>
                    <div class="col-md-6">
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
                <div class="modal-footer">
                    @if ($selected_id < 1)
                        <button type="button" wire:click.prevent="Save()"
                            class="btn btn-success close-modal">Guardar</button>
                    @else
                        <button type="button" wire:click.prevent="Update()"
                            class="btn btn-primary close-modal">Actualizar</button>
                    @endif
                    <button type="button" wire:click.prevent="resetUI()"
                        class="btn btn-secondary close-btn text-info" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
