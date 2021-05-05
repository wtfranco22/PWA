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