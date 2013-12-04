<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

	
require_once("../db.php");
require_once("../variables.php");$arts=array();


if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "update pedidos set agrupar='' WHERE estado='-' AND agrupar > 0 AND tip=$tip;";
$dbnivel->query($queryp);

$queryp= "delete from agrupedidos where estado='P' and tip=$tip;";
$dbnivel->query($queryp);

if (!$dbnivel->close()){die($dbnivel->error());};
?>


