{ ////////////////////////////////////  A L   I N I C I A R  /////////////////////////////////////
    /**
     * LET utilizado para las variables de un solo bloque, solo existe en ese momento
     * al cargar la pagina lo primero que ejecutamos es el select de id #grupo para la 
     * buscar los traceurs de un grupo, esperamos una respuesta de json y creamos los 
     * option necesarios para el select mencionado anteriormente
     * Luego llamado a cargarTablaTraceur para generar la tabla de todos los traceur
     * de la base de datos, todo esto en solo al cargar la pagina
     */
    $(function() {
        //se encarga de crear los modals esperando los valores por la BD
        $.get("./control/buscarTitulosImagenes.php", function(data) {
            for (let i = 0; i < 12; i++) {
                objImagen = data[i]; { //armo el modal, la primera parte creada es modalFade
                    var modalFade = $("<div></div>");
                    modalFade.attr("class", "modal fade");
                    modalFade.attr("id", "c" + objImagen.id_imagen);
                    modalFade.attr("tabindex", "-1");
                    modalFade.attr("aria-labelledby", "c" + objImagen.id_imagen + "Label");
                    modalFade.attr("aria-hidden", "true");
                } { //armado del modalDialog
                    modalDialog = $("<div></div>");
                    modalDialog.attr("class", "modal-dialog");
                } { //armado del modalContent
                    modalContent = $("<div></div>");
                    modalContent.attr("class", "modal-content");
                } { //armado de titulos de las imagenes con su boton
                    var li = $("<li></li>");
                    li.attr("class", "d-grid gap-2");
                    var button = $("<button></button>");
                    button.attr("type", "button");
                    button.attr("class", "btn btn-outline-light");
                    button.attr("data-bs-toggle", "modal");
                    button.attr("data-bs-target", "#c" + objImagen.id_imagen);
                    button.text(objImagen.nombre_imagen);
                    li.append(button);
                } { //agrego los titulos como primer hijo del modalImagenes
                    $("#modalImagenes").children().first().append(li); //armado del contenido que invoca a cada titulo 
                    divTitulo = $("<div></div>");
                    divTitulo.attr("class", "modal-header c1");
                    divCuerpo = $("<div></div>");
                    divCuerpo.attr("class", "modal-body c1");
                    titulo = $("<h5></h5>");
                    titulo.attr("class", "modal-title");
                    titulo.text(objImagen.nombre_imagen);
                } { //armado de boton junto a sus atributos
                    botonCerrar = $("<button></button>");
                    botonCerrar.attr("type", "button");
                    botonCerrar.attr("class", "btn-close");
                    botonCerrar.attr("data-bs-dismiss", "modal");
                    botonCerrar.attr("aria-label", "Close");
                } { //armado del contenido del cuerpo del modal
                    imagen = $("<img></img>");
                    descripcion = $("<p></p>");
                    descripcion.attr("align", "justify");
                    descripcion.text(objImagen.descripcion_imagen);
                    imagen.attr("src", objImagen.ruta_imagen);
                    imagen.attr("class", "w-100");
                    imagen.attr("alt", objImagen.nombre_imagen);
                } { //armado de la estructura completa ya listos con su contenido, desde los hijos hasta el padre
                    divTitulo.append(titulo);
                    divTitulo.append(botonCerrar);
                    divCuerpo.append(imagen);
                    divCuerpo.append(descripcion);
                    modalContent.append(divTitulo);
                    modalContent.append(divCuerpo);
                    modalDialog.append(modalContent);
                    modalFade.append(modalDialog);
                    $("#modalImagenes").append(modalFade);
                }
            }
        }, "json");
    });
}