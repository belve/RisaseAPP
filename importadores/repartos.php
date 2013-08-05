<?php 
$ini=2001;
set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};


##### datos OLD
$Ntab='Repartos';

$Nid='art_idArticulo';

$camp[1]='rep_NumeroRep';
$camp[2]='rep_fecha';
$camp[3]='rep_estado';




##### datos NEW
$nNtab="repartos";

$nNid='id';


$ncamp[1]='nomrep';
$ncamp[2]='fecha';
$ncamp[3]='estado';


$conn=odbc_connect('risase','edu','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT TOP 50 * FROM $Ntab where control < 1 ;";


$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}



$count=1;
while (odbc_fetch_row($rs))
  {$count++;


foreach($camp as $nkey => $nomcampo){
	 $valores[$count][$nkey]=trim(utf8_encode(odbc_result($rs,$nomcampo)));
}


  }

odbc_close($conn);


print_r ($valores);

require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};


?>



