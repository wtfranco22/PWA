<?php
/**
 * Esta es un script de autocarga de clases, donde al detectar una clase en funcionamiento
 * necesitamos cargarla, por lo tanto recorremos los archivos y si es el que se esta ocupando
 * se agregar para cargar sino no hay ninguna clase cargada
 */
spl_autoload_register(function($class){
    $colDirectorios = array(
        'modelo/',
        'modelo/conector/',
        'control/');
    foreach($colDirectorios as $directorio){
        if(file_exists('../'.$directorio.$class . '.php')){//referencia desde archivo clase
            //echo "se incluyo --> ".$directorio.$class . '.php <br>';
            include_once($directorio.$class . '.php');//referencia de este mismo archivo
            return;
        }
    }
});
?>