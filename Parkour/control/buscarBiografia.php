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
$traceur = $_POST['idtraceur'];
$sql = "SELECT * FROM traceur WHERE id_traceur =" . $traceur;
$consulta = $mysqli->query($sql);
if (!$consulta) {
  die('Consulta no válida: ');
} else {
  $biografia = $consulta->fetch_all(MYSQLI_ASSOC);
}
$sql = "SELECT * FROM imagen WHERE id_traceur = " . $traceur;
$consulta = $mysqli->query($sql);
if (!$consulta) {
  die('Consulta no válida: ');
} else {
  if ($consulta->num_rows > 0) {
    $biografia['imagenes'] = $consulta->fetch_all(MYSQLI_ASSOC);
  }
}

$res = json_encode($biografia);
$mysqli->close();
echo $res;
