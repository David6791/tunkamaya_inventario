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
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="animated flipInY col-lg-6 col-md-12 col-sm-12  ">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-barcode"></i>
                                        </div>
                                        <div class="count">CODIGO</div>
                                        <h3> {{ $codigo }}</h3>
                                    </div>
                                </div>
                                <div class="animated flipInY col-lg-6 col-md-12 col-sm-12  ">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-money"></i>
                                        </div>
                                        <div class="count">COSTO</div>
                                        <h3> {{ $costo }} Bs.</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="animated flipInY col-lg-6 col-md-12 col-sm-12  ">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-cog"></i>
                                        </div>
                                        <div class="count">ESTADO</div>
                                        <h3> {{ $status === 1 ? 'Inventariado' : 'No Inventariado' }} </h3>
                                    </div>
                                </div>
                                <div class="animated flipInY col-lg-6 col-md-12 col-sm-12  ">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-calendar"></i>
                                        </div>
                                        <div class="count">ADQUISICIÓN</div>
                                        <h3> {{ $fecha_registro }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="animated flipInY col-lg-12 col-md-12 col-sm-12  ">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-list-alt"></i>
                                        </div>
                                        <div class="count">DESCRIPCIÓN</div>
                                        <h3> {{ $description }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-secondary close-btn text-info"
                    data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </form>
    </div>
</div>
