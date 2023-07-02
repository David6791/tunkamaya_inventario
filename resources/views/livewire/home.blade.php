@extends('layouts.app')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <h2>Listado |<small>Actasdsadsaivos</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <a class=""><i class="fa fa-wrench"></i></a>
                </li>
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            @include('common.searchbox')
            <div class="table-responsive">
                <table class="table table-bordered table-striped mt-1 tchna">
                    <thead class="text-white" style="background: #003471">
                        <tr>
                            <th class="table-th text-white">NRO.</th>
                            <th class="table-th text-white text-center">CODIGO</th>
                            <th class="table-th text-white text-center">DESCRIPCION</th>
                            <th class="table-th text-white text-center">ACCION </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-success" href="javascript:void(0)" wire:click="addNweActivo()">Agregar
                        Activo Nuevo</a>
                </div>
            </div>
        </div>
    </div>
@endsection
