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
  $valores[trim(odbc_result($rs,$Nid))][1]=trim(odbc_result($rs,$Nrel));	
  $valores[trim(odbc_result($rs,$Nid))][2]=trim(utf8_encode(odbc_result($rs,$Nnom)));
  $valores[trim(odbc_result($rs,$Nid))][3]=trim(odbc_result($rs,$Nclave));
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

print_r($rows);

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




