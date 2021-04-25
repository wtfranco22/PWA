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
$sql = "SELECT * FROM equipo WHERE id_equipo > 1";
$consulta = $mysqli->query($sql);
if (!$consulta) {
  die('Consulta no válida: ');
}
$grupos = $consulta->fetch_all(MYSQLI_ASSOC);
$res = json_encode($grupos);
echo $res;
$mysqli->close();

