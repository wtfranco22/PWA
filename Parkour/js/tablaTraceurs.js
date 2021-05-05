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
        cargarTablaTraceur(0, 5); //creamos la tabla y por defecto cargamos "cero"
    });
} { ////////////////////////////////  T A B L A  D E  T R A C E U S  ////////////////////////////////
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