<?php
	
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$pendientes="";
$queryp= "select id from agrupedidos where tip=$tip AND estado IN ('-','P');";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$pendientes.=$row['id'] . ",";};

$pendientes=substr($pendientes, 0,-1);

$queryp= "UPDATE agrupedidos SET estado='A' WHERE id IN ($pendientes);";
$dbnivel->query($queryp);
//echo $queryp;

$queryp= "UPDATE pedidos SET estado='A' WHERE agrupar IN ($pendientes) AND tip=$tip;";
$dbnivel->query($queryp);
//echo $queryp;

if (!$dbnivel->close()){die($dbnivel->error());};

$arts=array();
echo json_encode($arts);

?>