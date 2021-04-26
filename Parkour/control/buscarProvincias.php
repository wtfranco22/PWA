<?php
$mysqli=conectar();
$caracter = $_POST['caracter'];
$obtenerdatos=consultar($mysqli,$caracter);
print_r($obtenerdatos);
cerrarconexion($mysqli);


function conectar(){

  $servername = "127.0.0.1";
  $username = "root";
  $password = "";
  $dbname = "parkour";
  $mysqli = new mysqli($servername, $username, $password, $dbname);
  if ($mysqli->connect_errno) {
      echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  return $mysqli;
}

function consultar($mysqli,$caracter){

    $sql="SELECT * FROM estado WHERE nombreEstado like "."'".$caracter."%'";
    $consulta = $mysqli->query($sql);
    if (!$consulta) {
        die('Consulta no válida: ');
    }
    else {
        $array = $consulta->fetch_all(MYSQLI_ASSOC);
        $resp = json_encode($array);
    }
    return $resp;

}
function cerrarconexion($mysqli){
    $mysqli->close();
  }