<?php include_once("./encabezado.php"); ?>
<div class="container-fluid c1">
    <div class="container imgfondo">
    <!--Vamos a darle una vista de tabs al usuario con 3 botones por ahora, y al seleccionar cargara el contenido correspondiente-->
        <nav>
            <div class="nav nav-tabs">
                <button class="nav-link conTabs" data-bs-toggle="tab" type="button" value="tabYamakasi">Yamakasi</button>
                <button class="nav-link conTabs" data-bs-toggle="tab" type="button" value="tabMovimientos">Movimientos</button>
                <button class="nav-link conTabs" data-bs-toggle="tab" type="button" value="tabReunionTraceur">Reunión Traceurs</button>
            </div>
        </nav>
        <!--Acontinuacion vamos agregando el contenido seleccionado del tab-->
        <article>
            <div id="nav-tabContent" class="d-flex justify-content-center align-items-center min-vh-100">
                <h1>SELECCIONA EL CONTENIDO</h1>
            </div>
        </article>
    </div>
</div>
<?php include_once("./footer.php"); ?>