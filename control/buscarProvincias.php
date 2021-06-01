<?php
include_once('../autoload.php');
/**
 * tenemos 2 valores ya que para asegurarnos de no tener problemas con
 * la busqueda de Provincia::listar(), por el id_pais e id_provincia
 */
$idPaisElegido=$_POST['idPaisElegido'];
$caracterProvincia=$_POST['caracterProvincia'];
$coleccionProvincias = Provincia::listar("id_pais=".$idPaisElegido." and nombre_provincia like '".$caracterProvincia."%"."'");
foreach($coleccionProvincias as $objProvincia){
    $res[]= ['nombre_provincia'=>$objProvincia->getNombre(),'id_provincia'=>$objProvincia->getIdProvincia()
      ];
}
print_r(json_encode($res));
?>