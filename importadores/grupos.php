<?php
set_time_limit(0);


##### datos OLD
$Ntab='Grupos';
$Nid='gru_IdGrupo';
$Nnom='gru_Grupo';

##### datos NEW
$nNtab="grupos";
$nNid='id';
$nNnom='nombre';

$conn=odbc_connect('risase','edu','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM $Ntab ORDER BY $Nid ASC ";

$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}




while (odbc_fetch_row($rs))
  {
  $valores[trim(odbc_result($rs,$Nid))]=trim(odbc_result($rs,$Nnom));
  }

odbc_close($conn);

require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};



$queryp= "delete from $nNtab;";
$dbnivel->query($queryp);

foreach ($valores as $val1 => $val2) {
$queryp= "INSERT INTO $nNtab ($nNid,$nNnom) values ('$val1','$val2');";
$dbnivel->query($queryp);
}

if (!$dbnivel->close()){die($dbnivel->error());};

echo json_encode($colores);
?>




