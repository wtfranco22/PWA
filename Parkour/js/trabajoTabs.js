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