/**
 * LET utilizado para las variables de un solo bloque, solo existe en ese momento
 * al cargar la pagina lo primero que ejecutamos es el select de id #grupo para la 
 * buscar los traceurs de un grupo, esperamos una respuesta de json y creamos los 
 * option necesarios para el select mencionado anteriormente
 * Luego llamado a cargarTablaTraceur para generar la tabla de todos los traceur
 * de la base de datos, todo esto en solo al cargar la pagina
 */
$(function() {
    $.get("./control/buscarGrupos.php", function(data) {
        //get por el llamado simple, sin parametro, buscamos los grupos de pk
        for (let i = 0; i < data.length; i++) {
            var objGrupo = data[i]; //de la coleccion del grupo de pk vamos de I hasta N
            var agregar = $('<option></option>'); //creamos option del select
            agregar.attr('value', objGrupo.id_equipo); //agregamos el atributo valor
            agregar.text(objGrupo.nombre_equipo); //texto al option
            $('#grupo').append(agregar); //llevamos al html donde se encuentra el id
        }
    }, "json");
    cargarTablaTraceur(0); //creamos la tabla y por defecto cargamos 'cero'
});


/**
 * al cambiar de valor el select de id #grupo vamos a buscar a todos los integrantes de pk
 * que pertenecen al grupo seleccionado por el usuario, usamos ajax para la peticion y 
 * utilizamos el metodo post en esta ocasion como respuesta esperamos un json
 */
$('#grupo').on("change", function() {
    //al detectar cambio de valor realizamos llamado a la funcion de ajax con metodo post
    $.post("./control/buscarIntegrantes.php", { idgrupo: this.value }, function(data) {
        //enviamos idgrupo y nos devuelve data que es de tipo json
        var opcIntegrantes = $('#integrantes');
        opcIntegrantes.empty(); //vaciamos para no renovar contenido, no agregar al que existe
        opcIntegrantes.append("<option>Integrantes</option>"); //agregamos al final
        for (let i = 0; i < data.length; i++) { //coleccion de traceurs en un grupo
            let objTraceur = data[i]; //guardamos como objeto 
            let agregar = $('<option></option>');
            agregar.attr('value', objTraceur.id_traceur); //llamamos al id_traceur con '.', recordemos que es JSON
            agregar.text(objTraceur.nombre_traceur);
            opcIntegrantes.append(agregar);
        }
    }, "json"); //de esta manera detectamos la respuesta de que tipo es
});

/**
 * Cuando se detecta un cambio de valor en el select id #integrantes vamos a buscar
 * la biografia del traceur a la base de datos con un llamado ajax con metodo post,
 * y esperamos la respuesta tipo json, vemos el contenido del traceur y si es que tiene imagenes
 */
$('#integrantes').on("change", function() {
    $.post("./control/buscarBiografia.php", { idtraceur: this.value }, function(data) {
        $('#contenidotraceur').empty(); //vaciamos el contenido renovar y no concatenar con el anterior
        var objTraceur = data[0];
        var agregarTitulo = $('<h1></h1>'); //creamos, damos valor y agregamos al html
        agregarTitulo.text('Biografía');
        $('#contenidotraceur').append(agregarTitulo);
        var agregarBiografia = $('<p></p>');
        agregarBiografia.addClass('p-3 mb-0');
        agregarBiografia.text(objTraceur.biografia_traceur); //ya con titulo y parrafo con valores
        $('#contenidotraceur').append(agregarBiografia);
        if (data['imagenes']) { //preguntamos si existen imagenes para recorrerlas
            var imagenes = data['imagenes'];
            for (let i = 0; i < imagenes.length; i++) {
                let agregaImg = $('<img>');
                agregaImg.attr('src', imagenes[i].ruta_imagen);
                agregaImg.attr('class', 'col-3 p-3');
                $('#contenidotraceur').append(agregaImg);
            }
        } //AL IDCONTENIDOTRACEUR no fue variable solo para recordar la alternativa
    }, "json");
});

/**
 * La siguiente funcion es para detectar los tabs de contenido, unificamos en una clase para 
 * detectar el click y cada boton tiene un valor, con el cual trabajamos para direccionar 
 * al contenido html que tenemos almacenado 
 */
$('.conTabs').on('click', function() {
    //usamos una clase para no realizar una funcion para cada boton
    let espera = 1000; //pausa de ejecucion
    $.ajax({
        url: ('./control/' + this.value + '.html'),
        beforeSend: function() {
            $('#nav-tabContent').html("<h1> C A R G A N D O . . . <h1>");
        },
        success: function(data) {
            setTimeout(function() {
                //cuando finalice el tiempo, ejecutamos
                $('#nav-tabContent').html(data);
            }, espera);
        }
    });
});


/**
 * al clickear el boton de 'anterior' o 'siguiente' para ver la tabla de traceur, detectamos el click
 * y dependiendo del valor mostramos el siguiente o anterior, si ya esta en la primera pagina anulamos 
 * el boton 'anterior' y lo mismo que si esta en la ultima hoja de la tabla deshabilitamos el click para 
 * dar en 'siguiente', incrementamos la pagina para direccionar, habilitamos o deshabilitamos botones y
 * llamamos a la funcion cargarTablaTraceur para mostrar
 */
var paginaIr = 0; //fuera de funciones para que sea global
$('#pag button').on('click', function() {
    var operador = this.value;
    (operador == '+') ? paginaIr = (++paginaIr): paginaIr = (--paginaIr);
    (paginaIr > 0) ? $('#pag li').first().removeClass('disabled'): $('#pag li').first().addClass('disabled');
    (paginaIr < 3) ? $('#pag li').last().removeClass('disabled'): $('#pag li').last().addClass('disabled');
    cargarTablaTraceur(paginaIr);
});

/**
 * el parametro ingrasado es el indice para mostrar los traceurs, luego de la peticion de ajax y el retorno
 * en json, vaciamos el ultimo hijo de la tabla para renovar contenido y no acumularlo con anteriores,
 * verificamos la cantidad de traceurs que sea valida para procesar, y usamos var hoy para calcular la edad
 * de los traceurs, creamos cada columna y luego la fila, dandole valor e insertando cada fila al cuerpo de la tabla
 * y ya que no sabemos la cantidad de traceur a recorrer vamos analizando con while si es necesario seguir o no
 * El parametro es un caracter, '+'/'-' para avanzar o retroceder
 */
function cargarTablaTraceur(indiceUsuario) {
    var numTraceur = (indiceUsuario * 5) + 1; //1-5, 6-10, 11-15, etc
    $.post("./control/buscarTodos.php", { indice: numTraceur }, function(data) {
        var cargarTabla = $('#tablaTraceurs');
        cargarTabla.children().last().empty();
        var cantTraceurs = data.length;
        var contador = 0;
        var procesar = (cantTraceurs > 0 && cantTraceurs <= 5);
        var hoy = new Date();
        while ((contador < cantTraceurs) && procesar) {
            let objTraceur = data[(contador)];
            let fila = document.createElement('tr'); //igual que $('<tr></tr>')
            let colum1 = document.createElement('td'); //igual que $('<td></td>')
            let colum2 = document.createElement('td');
            let colum3 = document.createElement('td');
            let colum4 = document.createElement('td');
            let colum5 = document.createElement('td');
            colum1.append(numTraceur);
            colum2.append(objTraceur.nombre_traceur + " " + objTraceur.apellido_traceur);
            //calulamos la edad del traceur, puede no ser necesario si se soluciona en backend
            let nacimiento = new Date(objTraceur.fechanacimiento_traceur);
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            colum3.append(edad);
            colum4.append(objTraceur.pais_traceur);
            colum5.append(objTraceur.nombre_equipo);
            fila.appendChild(colum1);
            fila.appendChild(colum2);
            fila.appendChild(colum3);
            fila.appendChild(colum4);
            fila.appendChild(colum5);
            cargarTabla.children().last().append(fila); //de la tabla, obtenemos el ultimo hijo 'tbody'
            contador++;
            numTraceur++; //utilizado para indicar la fila del traceur 
        }
    }, "json");
}