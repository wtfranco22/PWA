<?php include_once("./encabezado.php"); ?>
<main class="container-fluid c1">
    <div class="container text-center imgfondo">
        <div class="row justify-content-center min-vh-100">
            <!--aqui empieza formulario-->
            <div class="card bg-dark mt-3 w-75">
                <h5 class="card-header">FORMULARIO DE REGISTRO</h5>
                <div class="card-body">
                    <form class="mb-3 mt-3 w-100" action="#" method="POST" id="validarForm" autocomplete="off" novalidate>
                        <!--Campo nombreusuario reservado para los datos ingresados por teclado del usuario-->
                        <div class="row mb-2">
                            <div class="col col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="usuario" class="form-label">Usuario</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" aria-describedby="validarUsuario" placeholder="Usuario" required>
                                    <div id="validarUsuario" class="invalid-feedback">
                                        user invalido
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="contrasena" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="contrasena" name="contrasena" aria-describedby="validarContrasena" placeholder="Contraseña" required>
                                    <div id="validarContrasena" class="invalid-feedback">
                                        Mínimo 8 caracteres
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Esta campo se encuentra el valor del imput email-->
                        <div class="row mb-2">
                            <div class="col col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" aria-describedby="validarEmail" placeholder="Email" required>
                                    <div id="validarEmail" class="invalid-feedback">
                                        Email no valido
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="empresa" class="form-label"> Empresa</label>
                                    <input type="text" class="form-control" id="empresa" name="empresa" aria-describedby="validarEmpresa" placeholder="Empresa" required>
                                    <div id="validarEmpresa" class="invalid-feedback"> Ingrese la empresa
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--El campo de telefono es para el contacto del suscriptor de la pagina hacia el nuevo integrante-->
                        <div class="row mb-2">
                            <div class="col col-12 col-md-6 offset-md-3">
                                <div class="form-group mb-3">
                                    <label for="telefono" class="form-label"> Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" aria-describedby="validarTelefono" placeholder="Fijo/Celular" required>
                                    <div id="validarTelefono" class="invalid-feedback">Número no valido</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <!--Este campo es para validar el pais o provincia, tenemos un input disabled para no perder el valor-->
                            <div class="col col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="campoEstado" class="form-label">País</label>
                                    <input class="form-control" id="campoEstado" type="text" aria-describedby="validarEstado" placeholder="Pais" required>
                                    <input type="hidden" id="paisElegido" name="idPais" value="">
                                    <div id="campoSugerenciasEstado">
                                        <ul class="list-group"></ul>
                                    </div>
                                    <div id="validarEstado" class="invalid-feedback">País no encontrado</div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="campoProvincia" class="form-label">Provincia</label>
                                    <input class="form-control" id="campoProvincia" type="text" aria-describedby="validarProvincia" placeholder="Provincia" required>
                                    <input type="hidden" id="provinciaElegida" name="idProvincia" value="">
                                    <div id="campoSugerenciasProvincia">
                                        <ul class="list-group"></ul>
                                    </div>
                                    <div id="validarProvincia" class="invalid-feedback">Provincia no valida</div>
                                </div>
                            </div>
                        </div>
                        <!--destinamos un espacio comodo y solo para la el input comentario -->
                        <div class="row">
                            <div class="col col-12 col-md-8 offset-md-2 ">
                                <div class="form-group">
                                    <label class="mb-2" for="comentario">Comentario</label>
                                    <textarea class="form-control" name="comentario" id="comentario" cols="30" rows="10" placeholder="Comparte tu experiencia con nosotros!"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-secondary mt-4">Enviar</button>
                    </form>
                    <div id="mostrarMensaje">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include_once("./footer.php"); ?>