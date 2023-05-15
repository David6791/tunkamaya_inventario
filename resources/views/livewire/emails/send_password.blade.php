<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 fondo">
        <center>
            <img src="{{ asset('img/1591367741903.jpg') }}" alt="">
            <h3>Bienvenido al Sistema de Inventario APP</h3>
        </center>
    </div>
    <div class="col-md-8 fondo">
        <center>
            <p>Estimado {{ $name }}. Usted fue registrado en nuestro Sistema de Inventario web, para el cual se
                le
                envio lus credenciales.</p>
        </center>
    </div>
    <div class="col-md-8 fondo">

        <div class="hoja">
            <div>
                <h6>
                    Usuario: {{ $correos }} <br>
                    Contraseña: {{ $password }}
                </h6>
            </div>
        </div>

    </div>
    <div class="col-md-8 fondo">
        <center>
            <p>Estiamdo Usuario para tener una mayor seguridad con sus credenciales le recomendamos cambiar su
                contraseña. Y no compartir con ninguna otro usuario.</p>
        </center>
    </div>
</div>
<style>
    .fondo {
        background-color: rgb(32, 62, 123);
        color: aliceblue;
    }

    img {
        width: 200px;
    }

    .hoja {
        background-color: aliceblue;
        width: 300px;
        color: rgb(32, 62, 123);
        margin: 0 auto;

    }

    .hoja div h6 {
        margin: 40px;
    }
</style>
