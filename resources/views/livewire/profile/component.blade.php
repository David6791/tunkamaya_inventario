<div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Perfil |<small>Usuario</small></h2>
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
                                src="{{ asset('storage/usuarios/' . auth()->user()->imagen) }}" alt="Avatar"
                                title="Change the avatar" width="220">
                        </div>
                    </div>
                    <h3> {{ $user->name }}</h3>
                    <ul class="list-unstyled user_data">
                        <li>
                            <i class="fa fa-map-marker user-profile-icon"></i> {{ $user->address }}
                        </li>
                        <li>
                            <i class="fa fa-user user-profile-icon"></i> Administrador
                        </li>
                        <li class="m-top-xs">
                            <i class="fa fa-envelope-o user-profile-icon"></i>
                            <a href="http://www.kimlabs.com/profile/" target="_blank"> {{ $user->email }}</a>
                        </li>
                    </ul>
                    <button wire:click.prevent="Edit({{ $user->id }})" type="button"
                        class="btn btn-success text-white btn-block"><i class="fa fa-edit m-right-xs"></i> Editar
                        Perfil</button>

                    <a href="javascript:void(0)" wire:click="Edit_password({{ $user->id }})"
                        class="btn btn-primary text-white btn-block" title="Editar">
                        <i class="fa fa-edit m-right-xs"></i> Cambiar Contraseña
                    </a>
                    <br>
                </div>
                <div class="col-md-9 col-sm-12">
                    @if ($form)
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Nombres:</label>
                                    <input wire:model.lazy="name" type="text" class="form-control" required="">
                                    @error('name')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="surname">Apellidos :</label>
                                    <input wire:model.lazy="surname" type="text" class="form-control" name="surname"
                                        required="">
                                    @error('surname')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cedula_identidad">Cedula de Identidad :</label>
                                    <input wire:model.lazy="cedula_identidad" type="text" class="form-control"
                                        name="cedula_identidad" required="">
                                    @error('cedula_identidad')
                                        <span class="text-danger er">{{ $message }}</span>
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
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Imagen de Perfil</label>
                                    <input type="file" wire:model.lazy="image"
                                        accept="image/x-png,image/jpeg,image/jpg" class="form-control">
                                    @error('image')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                    <div wire:loading wire:target="image">Uploading...</div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="address">Direccion :</label>
                                    <input wire:model.lazy="address" type="text" class="form-control" name="address"
                                        required="">
                                    @error('address')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>
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
                            <div class="col-md-12">
                                <center>
                                    <x-save />
                                    <x-back />
                                </center>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Nombres:</label>
                                    <input disabled type="text" id="name" class="form-control"
                                        name="name" required="" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="surname">Apellidos:</label>
                                    <input disabled="text" id="surname" class="form-control" name="surname"
                                        required="" value="{{ $user->surname }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cedula_identidad">Cedula de Identidad:</label>
                                    <input disabled="text" id="cedula_identidad" class="form-control"
                                        name="cedula_identidad" required=""
                                        value="{{ $user->cedula_identidad }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Telefono :</label>
                                    <input disabled type="tel" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}"
                                        id="phone" class="form-control" name="phone" required=""
                                        value="{{ $user->phone }}">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="address">Direccion :</label>
                                    <input disabled type="text" id="address" class="form-control"
                                        name="address" required="" value="{{ $user->address }}">
                                </div>
                            </div>
                            <span class="section">Datos de Acceso</span>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Correo Electronico :</label>
                                    <input disabled type="text" id="email" class="form-control"
                                        name="email" required="" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Contraseña :</label>
                                    <input disabled type="password" id="password" class="form-control"
                                        name="password" required="" placeholder="***********">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="repassword">Repita Contraseña :</label>
                                    <input disabled type="password" id="repassword" class="form-control"
                                        name="repassword" required="" placeholder="***********">
                                </div>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('livewire.profile.form')
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        //para escuchar eventos
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('product-added', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('product-updated', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('profile_errors', msg => {
            Toast.fire({
                icon: 'error',
                title: msg
            })
        });
        window.livewire.on('profile_update', msg => {
            Toast.fire({
                icon: 'success',
                title: msg
            })
        });
        window.livewire.on('profile_success', msg => {
            Swal.fire(
                'Correcto',
                msg,
                'success'
            )
            $('#theModal').modal('hide');
        });
        $('#theModal').on('hidden.bs.modal', msg => {
            $('.er').css('display', 'none')
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
                window.livewire.emit('deleteRow', id);
                swal.close();
            }
        });
    }
</script>
