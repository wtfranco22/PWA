<?php
include_once('../autoload.php');
/**
 * siempre la condicion en equipo y imagen 1, es por la base de datos,
 * siempre >1 xq estan guardadas las fotos sobre la pagina bd
 */
$coleccionGrupos = Equipo::listar('id_equipo>1');
$resultado = [];
foreach($coleccionGrupos as $objGrupo){
  $resultado[]=[
    "id_equipo"=>$objGrupo->getIdEquipo(),
    "nombre_equipo"=>$objGrupo->getNombre()
  ];
}
print_r(json_encode($resultado));