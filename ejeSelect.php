<?php include_once("./encabezado.php"); ?>
<div class="container-fluid c1">
    <div class="container imgfondo min-vh-100">
        <section>
            <h1 class="text-center">
                Grupos de Parkour
            </h1>
            <p class="mt-5">
                Una gran mayoría de personas consideran que, para practicar parkour se necesita de un equipo especializado para ello. Donde se incluye un gasto monetario extra a las sesiones de entrenamiento. Sin embargo, la verdad es que no hay equipo alguno que sea indispensable. Sólo se necesita tener una buena condición física y tener tus cuatro extremidades en perfecto estado. Claro está, lo ideal es hacer la práctica con protección en la cabeza, rodillas y codos. Esto, por tu bienestar y seguridad física.
            </p>
        </section>
        <section>
        <!--Vamos a contenemos 2 formulario, el primero se carga al iniciar la pagina y la segunda carga sus elementos
        en el momento que el primer select fue seleccionado a valido-->
            <article>
                <div class="row">
                    <form class="col-12 col-md-6" action="#" method="POST">
                        <label for="grupo" class="form-label">Grupo a seleccionar</label>
                        <select id="grupo" class="form-select">
                            <option value="">Grupos</option>
                        </select>
                    </form>
                    <form class="col-12 col-md-6" action="#" method="POST">
                        <label for="integrantes" class="form-label">Integrantes a seleccionar</label>
                        <select id="integrantes" class="form-select">
                            <option value="">Integrantes</option>
                        </select>
                    </form>
                </div>
            </article>
        </section>
        <!--En este section vamos a dejar para agregar el contenido del traceur, ya sea su biografia con sus fotografias-->
        <section>
            <div id="contenidotraceur" class="text-center pt-5">
            </div>
        </section>
    </div>
</div>
<?php include_once("./footer.php"); ?>