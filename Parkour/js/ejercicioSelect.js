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