<?php
set_time_limit(0);


$conn=odbc_connect('risase','edu','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM Grupos";

$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}




while (odbc_fetch_row($rs))
  {
  $colores[odbc_result($rs,"gru_IdGrupo")]=odbc_result($rs,"gru_Grupo");
  }

odbc_close($conn);

require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};



$queryp= "delete from grupos;";
$dbnivel->query($queryp);

foreach ($colores as $id => $color) {
$queryp= "INSERT INTO grupos (id,nombre) values ('$id','$color');";
$dbnivel->query($queryp);
}

if (!$dbnivel->close()){die($dbnivel->error());};

echo json_encode($colores);
?>




