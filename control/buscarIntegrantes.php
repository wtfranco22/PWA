<?php
include_once('../autoload.php');
/**
 * vamos a buscar todos aquellos integrantes del grupo $idGrup, y de alli
 * guardamos nombre e id y retornamos
 */
$idGrup=$_POST['idgrupo'];
$coleccionTraceus = Traceur::listar('id_grupo='.$idGrup);
$resultado=[];
foreach($coleccionTraceus as $objTraceur){
    $resultado[]= ['nombre_traceur'=>$objTraceur->getNombre(),
        'id_traceur'=>$objTraceur->getIdTraceur()];
}
print_r(json_encode($resultado));
?>