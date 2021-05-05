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
}