<?php
set_time_limit(0);


##### datos OLD
$Ntab='Proveedores';

$Nid='pro_IdProveedor';

$camp[1]='pro_Nombre';
$camp[2]='pro_cif';
$camp[3]='pro_direccion';
$camp[4]='pro_cp';
$camp[5]='pro_poblacion';
$camp[6]='pro_provincia';
$camp[7]='pro_contacto';
$camp[8]='pro_telefono';
$camp[9]='pro_fax';
$camp[10]='pro_email';
$camp[11]='pro_dto1';
$camp[12]='pro_dto2';
$camp[13]='pro_iva';
$camp[14]='pro_Nombrecorto';


##### datos NEW
$nNtab="proveedores";

$nNid='id';


$ncamp[1]='nombre';
$ncamp[2]='cif';
$ncamp[3]='direccion';
$ncamp[4]='cp';
$ncamp[5]='poblacion';
$ncamp[6]='provincia';
$ncamp[7]='contacto';
$ncamp[8]='telefono';
$ncamp[9]='fax';
$ncamp[10]='email';
$ncamp[11]='dto1';
$ncamp[12]='dto2';
$ncamp[13]='iva';
$ncamp[14]='nomcorto';


$conn=odbc_connect('risasenew','edu','admin');

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




