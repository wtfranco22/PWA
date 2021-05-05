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
        //cargamos por defecto el select de los grupos que pueden seleccionar el usuario
        $.get("./control/buscarGrupos.php", function(data) {
            //get por el llamado simple, sin parametro, buscamos los grupos de parkour
            for (let i = 0; i < data.length; i++) {
                var objGrupo = data[i]; //de la coleccion del grupo de pk vamos de I hasta N
                var agregar = $("<option></option>"); //creamos option del select
                agregar.attr("value", objGrupo.id_equipo); //agregamos el atributo valor
                agregar.text(objGrupo.nombre_equipo); //texto al option
                $("#grupo").append(agregar); //llevamos al html donde se encuentra el id
            }
        }, "json");

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
        cargarTablaTraceur(0, 5); //creamos la tabla y por defecto cargamos "cero"
    });
}

{ ///////////////////////////   E J E R C I C I O   D E   S E L E C T   //////////////////////////
    /**
     * al cambiar de valor el select de id #grupo vamos a buscar a todos los integrantes de pk
     * que pertenecen al grupo seleccionado por el usuario, usamos ajax para la peticion y 
     * utilizamos el metodo post en esta ocasion como respuesta esperamos un json
     */
    $("#grupo").on("change", function() {
        //al detectar cambio de valor realizamos llamado a la funcion de ajax con metodo post
        $.post("control/buscarIntegrantes.php", { idgrupo: this.value }, function(data) {
            //enviamos idgrupo y nos devuelve data que es de tipo json
            var opcIntegrantes = $("#integrantes");
            opcIntegrantes.empty(); //vaciamos para no renovar contenido, no agregar al que existe
            opcIntegrantes.append("<option>Integrantes</option>"); //agregamos al final
            for (let i = 0; i < data.length; i++) { //coleccion de traceurs en un grupo
                let objTraceur = data[i]; //guardamos como objeto
                let agregar = $("<option></option>");
                agregar.attr("value", objTraceur.id_traceur); //llamamos al id_traceur con ".", recordemos que es JSON
                agregar.text(objTraceur.nombre_traceur);
                //agregar.attr("class", "text-dark");
                opcIntegrantes.append(agregar);
            }
        }, "json"); //de esta manera detectamos la respuesta de que tipo es
    });

    /**
     * Cuando se detecta un cambio de valor en el select id #integrantes vamos a buscar
     * la biografia del traceur a la base de datos con un llamado ajax con metodo post,
     * y esperamos la respuesta tipo json, vemos el contenido del traceur y si es que tiene imagenes
     */
    $("#integrantes").on("change", function() {
        $.post("./control/buscarBiografia.php", { idtraceur: this.value }, function(data) {
            var conTraceur = $("#contenidotraceur");
            conTraceur.empty(); //vaciamos el contenido renovar y no concatenar con el anterior
            var objTraceur = data;
            var agregarTitulo = $("<h1></h1>"); //creamos, damos valor y agregamos al html
            agregarTitulo.text("Biografía");
            conTraceur.append(agregarTitulo);
            var agregarBiografia = $("<p></p>");
            agregarBiografia.addClass("p-3 mb-0");
            agregarBiografia.text(objTraceur.biografia); //ya con titulo y parrafo con valores
            conTraceur.append(agregarBiografia);
            if (objTraceur.imagenes) { //preguntamos si existen imagenes para recorrerlas
                var imagenes = objTraceur.imagenes;
                for (let i = 0; i < imagenes.length; i++) {
                    let agregaImg = $("<img>");
                    agregaImg.attr("src", imagenes[i].ruta_imagen);
                    agregaImg.attr("class", "col-3 p-3");
                    conTraceur.append(agregaImg);
                }
            }
        }, "json");
    });
}

{ ////////////////////////////////  T R A B A J O  C O N  T A B S  ////////////////////////////////
    /**
     * La siguiente funcion es para detectar los tabs de contenido, unificamos en una clase para 
     * detectar el click y cada boton tiene un valor, con el cual trabajamos para direccionar 
     * al contenido html que tenemos almacenado 
     */
    $(".conTabs").on("click", function() {
        //usamos una clase para no realizar una funcion para cada boton
        let espera = 1000; //pausa de ejecucion
        $.ajax({
            url: ("./control/" + this.value + ".html"),
            beforeSend: function() {
                $("#nav-tabContent").html("<h1> C A R G A N D O . . . <h1>");
            },
            success: function(data) {
                setTimeout(function() {
                    //cuando finalice el tiempo, ejecutamos
                    $("#nav-tabContent").html(data);
                }, espera);
            }
        });
    });
}

{ ////////////////////////////////  T A B L A  D E  T R A C E U S  ////////////////////////////////
    /**
     * al clickear el boton de "anterior" o "siguiente" para ver la tabla de traceur, detectamos el click
     * y dependiendo del valor mostramos el siguiente o anterior, si ya esta en la primera pagina anulamos 
     * el boton "anterior" y lo mismo que si esta en la ultima hoja de la tabla deshabilitamos el click para 
     * dar en "siguiente", incrementamos la pagina para direccionar, habilitamos o deshabilitamos botones y
     * llamamos a la funcion cargarTablaTraceur para mostrar
     */
    var paginaIr = 0; //fuera de funciones para que sea global
    var cantFilas = 5;
    var indiceInicial = 0;
    var indiceFinal = 3;
    $("#pag button").on("click", function() {
        var operador = this.value;
        (operador == "+") ? paginaIr = (++paginaIr): paginaIr = (--paginaIr);
        (paginaIr > indiceInicial) ? $("#pag li").first().removeClass("disabled"): $("#pag li").first().addClass("disabled");
        (paginaIr < indiceFinal) ? $("#pag li").last().removeClass("disabled"): $("#pag li").last().addClass("disabled");
        cargarTablaTraceur(paginaIr, cantFilas);
    });

    /**
     * el parametro ingrasado es el indice para mostrar los traceurs, luego de la peticion de ajax y el retorno
     * en json, vaciamos el ultimo hijo de la tabla para renovar contenido y no acumularlo con anteriores,
     * verificamos la cantidad de traceurs que sea valida para procesar, y usamos var hoy para calcular la edad
     * de los traceurs, creamos cada columna y luego la fila, dandole valor e insertando cada fila al cuerpo de la tabla
     * y ya que no sabemos la cantidad de traceur a recorrer vamos analizando con while si es necesario seguir o no
     * El parametro es un caracter, "+"/"-" para avanzar o retroceder
     */
    function cargarTablaTraceur(indiceUsuario, cant) {
        var numTraceur = (indiceUsuario * 5) + 1; //1-5, 6-10, 11-15, etc
        $.post("./control/buscarTodos.php", { indice: numTraceur, cantTraceurs: cant }, function(data) {
            var cargarTabla = $("#tablaTraceurs");
            cargarTabla.children().last().empty();
            var cantTraceurs = data.length;
            var contador = 0;
            var procesar = (cantTraceurs > indiceInicial && cantTraceurs <= cantFilas);
            let hoy = new Date();
            while ((contador < cantTraceurs) && procesar) { //recorremos con while los objetos traceurs
                var objTraceur = data[(contador)]; { //Armamos los elementos de la fila
                    var fila = document.createElement("tr"); //igual que $("<tr></tr>")
                    var colum1 = document.createElement("td"); //igual que $("<td></td>")
                    var colum2 = document.createElement("td");
                    var colum3 = document.createElement("td");
                    var colum4 = document.createElement("td");
                    var colum5 = document.createElement("td");
                } { //Agregado de las columnas a la fila para integrar a la tabla
                    colum1.append(numTraceur);
                    colum2.append(objTraceur.nombre_traceur + " " + objTraceur.apellido_traceur);
                    var nacimiento = new Date(objTraceur.fechanacimiento_traceur);
                    var edad = hoy.getFullYear() - nacimiento.getFullYear();
                    colum3.append(edad);
                    colum4.append(objTraceur.pais_traceur);
                    colum5.append(objTraceur.nombre_equipo);
                } {
                    fila.appendChild(colum1);
                    fila.appendChild(colum2);
                    fila.appendChild(colum3);
                    fila.appendChild(colum4);
                    fila.appendChild(colum5);
                    cargarTabla.children().last().append(fila);
                }
                //de la tabla, obtenemos el ultimo hijo "tbody"
                contador++;
                numTraceur++;
                //utilizado para indicar la fila del traceur 
            }
        }, "json");
    }
}

{ /////////////////////////  F O R M U L A R I O   S U S C R I P C I O N  //////////////////////////
    //funcion utilizada por el validator de bootstrap 5
    (function() {
        Array.prototype.slice.call($("#validarForm"))
            .forEach(function(form) {
                (form).addEventListener("submit", function(event) {
                    if (!form.checkValidity()) { //chequeamos que este bien sino entramos al if
                        event.preventDefault(); //no recargamos la pagina
                        event.stopPropagation(); //detenemos el envio de formulario
                    }
                    form.classList.add("was-validated");
                }, false)
            })
    })()

    //Es un llamado ajax para enviar los datos del formulario sin salir de la pagina e imprimimos "data"
    $("#validarForm").on("submit", function() {
        $.ajax({
            type: "POST",
            url: ("./control/control_insertar.php"),
            data: $(this).serialize(),
            success: function(data) {
                $("#mostrarMensaje").empty();
                $("#mostrarMensaje").html(data);
                if (data != "falta de datos") {
                    $("#validarForm").remove();
                }
            }
        });
        return false;
    });
    /**
     * El campo de usuario cuando realiza un cambio vemos si esta vacio,
     * vemos si el usuario existe ya en la base de datos
     */
    $("#usuario").on("change", function() {
        $("validarUsuario").empty();
        $("#usuario").hasClass("is-valid") ? $("#usuario").removeClass("is-valid") : $("#usuario").removeClass("is-invalid");
        var expRegUsuario = /^[a-zA-Z0-9-_.áúíóúÁÉÍÓÚÑñ]+$/
        if (expRegUsuario.test(this.value)) {
            $.post("./control/control_formulario.php", { usuario: this.value }, function(data) {
                if (data == "1") { //ya existe el usuario
                    $("#validarUsuario").text("Usuario registrado");
                    $("#usuario").addClass("is-invalid");
                } else {
                    $("#validarUsuario").text("Usuario no valido");
                    $("#usuario").addClass("is-valid");
                }
            });
        } else {
            $("#validarUsuario").text("Usuario no valido");
            $("#usuario").addClass("is-invalid");
        }
    });
    //verificamos que la contrasena cumpla con los requisitos minimos basados en regex
    $("#contrasena").on("change", function() {
        $("#contrasena").hasClass("is-valid") ? $("#contrasena").removeClass("is-valid") : $("#contrasena").removeClass("is-invalid");
        var expRegContrasena = /^[a-zA-z0-9-_.áúíóúÁÉÍÓÚÑñ]{8,}$/;
        if (expRegContrasena.test(this.value)) {
            $("#contrasena").addClass("is-valid");
        } else {
            $("#contrasena").addClass("is-invalid");
        }
    });
    /**
     * al valor del email aparte de validarlo con la expresion regular,
     * validamos si el correo ya existe en la base de datos
     */
    $("#email").on("change", function() {
        $("#validarEmail").empty();
        $("#email").hasClass("is-valid") ? $("#email").removeClass("is-valid") : $("#email").removeClass("is-invalid");
        var expRegEmail = /^[a-z0-9!#$%&"*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&"*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
        if (expRegEmail.test(this.value)) {
            $.post("./control/control_formulario.php", { email: this.value }, function(data) {
                if (data == "1") { //ya existe el email
                    $("#email").addClass("is-invalid");
                    $("#validarEmail").text("Esta email ya esta registrado");
                } else {
                    $("#validarEmail").text("Email no valido");
                    $("#email").addClass("is-valid");
                }
            });
        } else {
            $("#email").addClass("is-invalid");
            $("#validarEmail").text("Email no valido");
        }
    });

    //solo verificamos que la logitud superar a 10 y solo sean numeros
    $("#telefono").on("change", function() {
        $("#telefono").hasClass("is-valid") ? $("#telefono").removeClass("is-valid") : $("#telefono").removeClass("is-invalid");
        var expRegTelefono = /^[0-9]{10,}$/;
        if (expRegTelefono.test(this.value)) {
            $("#telefono").addClass("is-valid");
        } else {
            $("#telefono").addClass("is-invalid");
        }
    });

    { ///////////////////////////   P A I S   Y   P R O V I N C I A   ///////////////////////////
        /**
         * Cuando el usuario ingresa una letra en el campo, tomamos el valor y
         * sugerimos los paises a traves de la letra ingresada
         */
        $("#campoEstado").on("keyup", function() {
            if (this.value != "") {
                $("#campoSugerenciasEstado ul").empty();
                $.post("./control/buscarEstados.php", { caracter: this.value }, function(data) {
                    for (let i = 0; i < data.length; i++) { //recorremos los objectos sugeridos
                        var item = $("<li></li>");
                        item.attr("class", "list-group-item");
                        var objEstado = data[i];
                        item.text(objEstado.nombre_pais);
                        $("#campoSugerenciasEstado ul").append(item);
                    }
                }, "json");
            } else {
                $("#campoSugerenciasEstado ul").empty();
            }
        });
        /**
         * Al momento del cambio de valor sobre el id, detectamos y verificamos si ese valor
         * existe en la base de datos y luego tomamos las siguientes decisiones
         */
        $("#campoEstado").on("change", function() {
            $("#campoSugerenciasEstado ul").empty();
            $("#campoEstado").hasClass("is-valid") ? $("#campoEstado").removeClass("is-valid") : $("#campoEstado").removeClass("is-invalid");
            $.post("./control/control_formulario.php", { pais: this.value }, function(data) {
                $("#paisElegido").empty();
                if (data.length == 1) { //preguntamos si existe un objeto
                    $("#paisElegido").attr("value", data[0].id_pais);
                    $("#campoEstado").addClass("is-valid");
                } else {
                    $("#paisElegido").attr("value", null);
                    $("#campoEstado").addClass("is-invalid");
                }
            }, "json");
        });
        /**
         * verificamos si existe un pais antes seleccionado sino no vamos a la base de datos,
         * de existe el pais seleccionado buscamos las sugerencias del pais y letra combinada
         */
        $("#campoProvincia").on("keyup", function() {
            var idPaisElegido = $("#paisElegido").val();
            if (this.value != "" && idPaisElegido != null) {
                $("#campoSugerenciasProvincia ul").empty();
                $.post("./control/buscarProvincias.php", { caracterProvincia: this.value, idPaisElegido: idPaisElegido }, function(data) {
                    for (let i = 0; i < data.length; i++) {
                        var item = $("<li></li>");
                        item.attr("class", "list-group-item");
                        var objProvincia = data[i];
                        item.text(objProvincia.nombre_provincia);
                        $("#campoSugerenciasProvincia ul").append(item);
                    }
                }, "json");
            } else {
                $("#campoSugerenciasProvincia ul").empty();
            }
        });
        /**
         * antes de consultar en la BD verificamos si existe un valor selecciona al anteriormente
         * si existe idPais y un nombre provincia y vemos si es valido
         */
        $("#campoProvincia").on("change", function() {
            $("#campoSugerenciasProvincia ul").empty();
            $("#campoProvincia").hasClass("is-valid") ? $("#campoProvincia").removeClass("is-valid") : $("#campoProvincia").removeClass("is-invalid");
            var paisElegido = $("#paisElegido").val();
            if (paisElegido != null) {
                $.post("./control/control_formulario.php", { provincia: this.value, idPais: paisElegido }, function(data) {
                    $("#provinciaElegida").empty();
                    if (data.length == 1) { //preguntamos si existe
                        $("#provinciaElegida").attr("value", data[0].id_provincia);
                        $("#campoProvincia").addClass("is-valid");
                    } else {
                        $("#provinciaElegida").attr("value", null);
                        $("#campoProvincia").addClass("is-invalid");
                    }
                }, "json");
            }
        });
    }
}