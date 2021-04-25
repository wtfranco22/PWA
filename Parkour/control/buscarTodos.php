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
$indice = $_POST['indice'];
$sql = "SELECT * FROM traceur t INNER JOIN equipo e ON t.id_grupo=e.id_equipo LIMIT " . $indice . ",5";
$consulta = $mysqli->query($sql);
if (!$consulta) {
  die('Consulta no válida: ');
}
$perfil = $consulta->fetch_all(MYSQLI_ASSOC);
$res = json_encode($perfil);
$mysqli->close();
print_r($res);