<?php
set_time_limit(0);


##### datos OLD
$Ntab='Subgrupos';

$Nid='sub_IdSubgrupo';
$Nrel='sub_IdGrupo';
$Nnom='sub_Subgrupo';
$Nclave='sub_numero';

##### datos NEW
$nNtab="subgrupos";

$nNid='id';
$nNrel='id_grupo';
$nNnom='nombre';
$nNclave='clave';

$conn=odbc_connect('risasenew','edu','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM $Ntab ORDER BY $Nid ASC ";

$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}




while (odbc_fetch_row($rs))
  {
  $valores[trim(odbc_result($rs,$Nid))][1]=trim(odbc_result($rs,$Nrel));	
  $valores[trim(odbc_result($rs,$Nid))][2]=trim(utf8_encode(odbc_result($rs,$Nnom)));
  $valores[trim(odbc_result($rs,$Nid))][3]=trim(odbc_result($rs,$Nclave));
  }

odbc_close($conn);

require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};



$queryp= "delete from $nNtab;";
$dbnivel->query($queryp);

foreach ($valores as $val1 => $val2) {
$nval1=$val2[1];$nval2=$val2[2];$nval3=$val2[3];
$queryp= "INSERT INTO $nNtab ($nNid,$nNrel,$nNnom,$nNclave) values ('$val1','$nval1','$nval2','$nval3');";
$dbnivel->query($queryp);
}

if (!$dbnivel->close()){die($dbnivel->error());};

echo json_encode($valores);
?>




