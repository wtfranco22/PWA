<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "parkour";
$port = "3306";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname, $port);
if ($mysqli->connect_errno) {
  echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$grupo = $_POST['idgrupo'];
$sql = "SELECT * FROM traceur WHERE id_grupo = ".$grupo ;
$consulta = $mysqli->query($sql);
if (!$consulta) {
  die('Consulta no válida: ');
}/* else {
  $opciones = [];
  while ($row = $consulta->fetch_assoc()) {
    $opciones []=  $row['idtraceur'] . '">' . $row['nombre'] . '</option>';
  }
}
echo $opciones;*/
$opciones = $consulta->fetch_all(MYSQLI_ASSOC);
$res = json_encode($opciones);
$mysqli->close();
echo $res;

