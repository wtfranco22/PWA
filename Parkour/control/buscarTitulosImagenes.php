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
$sql = "SELECT * FROM imagen WHERE  nivel_imagen>0";
$consulta = $mysqli->query($sql);

if (!$consulta) {
  die('Consulta no válida: ');
} else {
  $i=0;
  $array = array();
  while ($row = $consulta->fetch_assoc()) {
    $array[$i]=$row;
    $i++;
  }
  $temp = array();
  $new = array();
  foreach($array as $value){
      if(!in_array($value["nombre_imagen"],$temp)){
        $temp[] = $value["nombre_imagen"];
        $new[] = $value;
      }
  }
  
  $res = json_encode($new);
  
}

print_r($res);
$mysqli->close();

