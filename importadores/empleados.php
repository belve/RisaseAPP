<?php
set_time_limit(0);


##### datos OLD
$Ntab='Empleados';

$Nid='emp_idEmpleado';

$camp[1]='emp_idTienda';
$camp[2]='emp_Nombre';
$camp[3]='emp_Apellido1';
$camp[4]='emp_Apellido2';
$camp[5]='emp_Trabajando';
$camp[6]='emp_Orden';




##### datos NEW
$nNtab="empleados";

$nNid='id';


$ncamp[1]='id_tienda';
$ncamp[2]='nombre';
$ncamp[3]='apellido1';
$ncamp[4]='apellido2';
$ncamp[5]='trabajando';
$ncamp[6]='orden';


/*
$conn=odbc_connect('risasenew','remoto','azul88');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM $Ntab ORDER BY $Nid ASC ";

$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}




while (odbc_fetch_row($rs))
  {


foreach($camp as $nkey => $nomcampo){
	 $valores[trim(odbc_result($rs,$Nid))][$nkey]=trim(utf8_encode(odbc_result($rs,$nomcampo)));
}


  }

odbc_close($conn);

*/



include('../adodb5/adodb.inc.php'); $driv="odbc_mssql";
$db =& ADONewConnection($driv);
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risase;";
$db->Connect($dsn,'remoto','azul88');
$db->debug = false;
$sql="SELECT * FROM $Ntab ORDER BY $Nid ASC ";
$rs = $db->Execute($sql);


$rows = $rs->GetRows();
foreach ($rows as $key => $row) {foreach($camp as $nkey => $nomcampo){
	 $valores[trim($row[0])][$nkey]=trim(utf8_encode($row[$nkey]));

}}

$db->Close();





require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};



$queryp= "delete from $nNtab;";
$dbnivel->query($queryp);

foreach ($valores as $val1 => $val2) {
$nval1=$val2[1];$nval2=$val2[2];$nval3=$val2[3];

$sqlcamps="";$sqlvals="";
foreach ($val2 as $nnkey => $valuecamp)	{
	
	$sqlcamps .= "$ncamp[$nnkey],";
	$sqlvals .= "'$valuecamp',";
}
	
$sqlcamps=substr($sqlcamps, 0,strlen($sqlcamps)-1);	
$sqlvals=substr($sqlvals, 0,strlen($sqlvals)-1);	
	
$queryp= "INSERT INTO $nNtab ($nNid,$sqlcamps) values ('$val1',$sqlvals);";
$dbnivel->query($queryp);
}

if (!$dbnivel->close()){die($dbnivel->error());};

echo json_encode($valores);
?>




