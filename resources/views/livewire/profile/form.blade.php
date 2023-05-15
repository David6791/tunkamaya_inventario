<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark-color">
                <h6 class="modal-title">
                    <b>CAMBIAR CONTRASEÑA</b>
                </h6>
                <h6 class="text-center text-warning" wire:loading> Por favor espere.</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="old_password">Ingrese Contraseña Antigua :</label>
                        <div class="input-group">
                            <input wire:model.lazy="old_password" type="{{ $oldShowPassword ? 'text' : 'password' }}"
                                id="old_password" class="form-control" name="old_password" required=""
                                placeholder="***********">
                            <span class="input-group-btn">
                                <button wire:click="$toggle('oldShowPassword')" type="button" class="btn"> <i
                                        class="{{ $oldShowPassword ? 'fa fa-eye-slash' : 'fa fa-eye' }}"></i> </button>
                            </span>
                        </div>
                        @error('old_password')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="password">Ingrese Nueva Contraseña :</label>
                        <div class="input-group">
                            <input wire:model.lazy="password" type="{{ $showPassword ? 'text' : 'password' }}"
                                id="password" class="form-control" name="password" required=""
                                placeholder="***********">
                            <span class="input-group-btn">
                                <button wire:click="$toggle('showPassword')" type="button" class="btn"> <i
                                        class="{{ $showPassword ? 'fa fa-eye-slash' : 'fa fa-eye' }}"></i> </button>
                            </span>
                        </div>
                        @error('password')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="re_password">Repita Nueva Contraseña :</label>
                            <div class="input-group">
                                <input wire:model.lazy="re_password" type="{{ $showRePassword ? 'text' : 'password' }}"
                                    id="re_password" class="form-control" name="re_password" required=""
                                    placeholder="***********">
                                <span class="input-group-btn">
                                    <button wire:click="$toggle('showRePassword')" type="button" class="btn"> <i
                                            class="{{ $showRePassword ? 'fa fa-eye-slash' : 'fa fa-eye' }}"></i>
                                    </button>
                                </span>
                            </div>
                            @error('re_password')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="SaveNewPassword()"
                        class="btn btn-success close-modal">Guardar</button>
                @else
                    <button type="button" wire:click.prevent="SaveNewPassword()"
                        class="btn btn-primary close-modal">Actualizar</button>
                @endif
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-secondary close-btn text-info"
                    data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </form>
    </div>
</div>
<script>
    function togglePassword() {
        var passwordInput = document.getElementById("old_password");
        if (passwordInput.type === "text") {
            passwordInput.type = "password";
        } else {
            passwordInput.type = "text";
        }
    }
</script>
