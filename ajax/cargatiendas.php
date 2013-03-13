<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id, orden, id_tienda from tiendas where activa=1 ORDER BY orden ASC";

$listado="";

$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	
	$id=$row['id'];$orden=$row['orden'];$idtienda=$row['id_tienda'];
	if($orden < 10){$orden="0" . $orden;};
	$listado .="<li id='t-$id' onclick='javascript:cargatiend($id)'>$orden - $idtienda</li>";
	
};

if (!$dbnivel->close()){die($dbnivel->error());};



echo $listado;