<?php
set_time_limit(0);


$conn=odbc_connect('risase','edu','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM Colores";

$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}




while (odbc_fetch_row($rs))
  {
  $colores[odbc_result($rs,"col_IdColor")]=odbc_result($rs,"col_Color");
  }

odbc_close($conn);

require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};



$queryp= "delete from colores;";
$dbnivel->query($queryp);

foreach ($colores as $id => $color) {
$queryp= "INSERT INTO colores (id,nombre) values ('$id','$color');";
$dbnivel->query($queryp);
}

if (!$dbnivel->close()){die($dbnivel->error());};

echo json_encode($colores);
?>




