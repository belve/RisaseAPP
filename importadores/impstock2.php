<?php

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};



$conn=odbc_connect($t,'local','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM Articulos;";


$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}



$count=1;$values="";
while (odbc_fetch_row($rs))
 {

	$art_idArticulo=trim(utf8_encode(odbc_result($rs,'art_CodBarras')));
	$art_UniStock=trim(utf8_encode(odbc_result($rs,'art_UniStock')));
	$art_UniMini=trim(utf8_encode(odbc_result($rs,'art_UniMinimas')));
	
	$values .="('$art_idArticulo','$art_UniStock','$art_UniMini'),";
  }

odbc_close($conn);

$values=substr($values, 0,strlen($values)-1);	


$dbnivelBAK=new DB('192.168.1.11','tpv','tpv','tpv_backup');

$queryp= "INSERT INTO stocklocal_$idt (cod,stock,alarma) VALUES $values;";
$dbnivelBAK->query($queryp);

if (!$dbnivel->close()){die($dbnivel->error());};


?>