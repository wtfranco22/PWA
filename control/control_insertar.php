<?php
include_once('../autoload.php');
/**
 * por ultimo, este script se encarga de insertar un suscriptor junto a 
 * su comentario, verificamos si ya no existia en la BD nuevamente y
 * se inserta, retornando un echo si fue con exito o no
 */

if (($_POST["contrasena"] != null) && ($_POST["empresa"] != null) && ($_POST["telefono"] != null) && ($_POST["usuario"] != null) && ($_POST["email"] != null) && ($_POST['idProvincia'] != null)) {
    //$_POST["idPais"] no hace falta, fue utilizado para verificar que se ingrese la provincia correcta, pero el objPro ya sabe su id_pais
    $objPro = new Provincia();
    $objPro->setIdProvincia($_POST['idProvincia']);
    $objPro->cargar();
    $nombre = $_POST["usuario"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $empresa = $_POST["empresa"];
    $contra = $_POST["contrasena"];
    $objSuscriptor = new Suscriptor();
    $colUser = Suscriptor::listar("nombre_suscriptor='" . $nombre . "'");
    $colCorreo = Suscriptor::listar("email_suscriptor='" . $email . "'");
    $res = "";
    if ($colUser != null || $colCorreo != null) {
        ($colUser != null) ? $res .= "error, ya existe el usuario\n" : $res .= "error, ya existe el email\n";
    } else {
        $objSuscriptor->setear($nombre, $empresa, $email, $contra, $telefono, $objPro);
        if ($objSuscriptor->insertar()) { //insertar devuelve booleano
            $res .= "\nSe ha suscripto con éxito!\n";
            $objComentario = new Comentario();
            $contenidoComentario = $_POST['comentario'];
            $objComentario->setear(1, $contenidoComentario, $objSuscriptor);
            //1 xq el id es autoincrementable, solo necesita un numero aleatorio
            if ($objComentario->insertar()) {
                $res .= "\n Se ha registrado el comentario \n";
            } else {
                $res .= "\n ERROR: Al insertar el comentario \n";
            }
        } else {
            $res .= "\n EROOR al suscribirse en la pagina \n";
        }
    }
    echo $res;
} else {
    echo "falta de datos";
}
