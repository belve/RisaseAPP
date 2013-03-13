<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id, orden from tiendas where id_tienda='$cod'";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$posi=$row['orden'];$cambio=$row['id'];};


if($orden=="up"){

$infe=$posi-1;
$queryp= "select id from tiendas where orden=$infe";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$subo=$row['id'];}

$queryp= "update tiendas set orden=orden+1 where id=$subo;";
$dbnivel->query($queryp);
$queryp= "update tiendas set orden=orden-1 where id=$cambio;";
$dbnivel->query($queryp);


}

if($orden=="dw"){
$infe=$posi+1;
$queryp= "select id from tiendas where orden=$infe";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$subo=$row['id'];}

$queryp= "update tiendas set orden=orden-1 where id=$subo;";
$dbnivel->query($queryp);
$queryp= "update tiendas set orden=orden+1 where id=$cambio;";
$dbnivel->query($queryp);	
}




$queryp= "select id, orden, id_tienda from tiendas where activa=1 ORDER BY orden ASC";

$listado="";

$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
		
	
	$id=$row['id'];$orden=$row['orden'];$idtienda=$row['id_tienda'];
	if($orden==$infe){$class="class='tselected'";}else{$class="";};
	
	if($orden < 10){$orden="0" . $orden;};
	
	$listado .="<li $class id='t-$id' onclick='javascript:cargatiend($id)'>$orden - $idtienda</li>";
	
};

if (!$dbnivel->close()){die($dbnivel->error());};



echo $listado;


