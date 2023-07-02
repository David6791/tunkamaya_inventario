<div>
    <div class="page-title">
        <div class="title_left">
            <h3>Institucion: <small class="text-danger"> {{ session('nombre_institucion') }}</small></h3>
        </div>
        <div class="title_right">
            <div class="col-md-5 col-sm-5 form-group pull-right">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-round btn-success text-white" type="button" href="javascript:void(0)"
                            wire:click="cambiar_institucion({{ session('institucion') }})">Cambiar de
                            Institucion</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.dashboard.form')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('open', msg => {
                $('#modalCambioInstitucion').modal('show');
            });
        });

        function Confirm(id, products) {
            if (products > 0) {
                Swal.fire('NO SE PUEDE ELIMINAR LA CATEGORIA PORQUE TIENE PRODUCTOS RELACIONADOS')
                return;
            }
            Swal.fire({
                title: 'Confirmar',
                text: 'Confirmas cambiar de Institucion',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'CERRAR',
                CancelButtonColor: '#fff',
                confirmButtonColor: '#3b3f5c',
                confirmButtonText: 'Aceptar'
            }).then(function(result) {
                if (result.value) {
                    window.livewire.emit('CmabioInstitucion', id);
                    swal.close();
                }
            });
        }
    </script>
</div>
