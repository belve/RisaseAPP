<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$value=str_replace(',','.',$value);
	
$queryp= "update $tabla set $campo='$value' where id=$id;";
$dbnivel->query($queryp);
	

echo $queryp;




if (!$dbnivel->close()){die($dbnivel->error());};



?>