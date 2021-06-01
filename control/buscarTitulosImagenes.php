<?php
include_once('../autoload.php');
/**
 * el nivel de imagen es mayor a cero xq si es igual a cero se encontrarian
 * las imagenes que utiliza la misma pagina, agrupamos y tomamos la primer imagen
 * que devuelva del agrupamiento por nombre, y pedimos solo 12 tuplas
 */
$coleccionImagenes = Imagen::listar('nivel_imagen>0 GROUP BY(nombre_imagen) LIMIT 12');
$res=[];
foreach($coleccionImagenes as $objImagen){
    $res[]= ['id_imagen'=>$objImagen->getIdImagen(),
        'nombre_imagen'=>$objImagen->getNombre(),
        'ruta_imagen'=>$objImagen->getRuta(),
        'descripcion_imagen'=>$objImagen->getDescripcion()
      ];
}
print_r(json_encode($res));
?>