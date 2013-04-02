<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select id_tienda, cantidad, stockmin from repartir where id_articulo=$idarticulo;";
$dbnivel->query($queryp); echo $queryp . '</br>';
while ($row = $dbnivel->fetchassoc()){	$repartos[$row['id_tienda']]['cantidad']=$row['cantidad'];
										$repartos[$row['id_tienda']]['stockmin']=$row['stockmin'];};


$queryp= "delete from repartir where id_articulo=$idarticulo_new;";
$dbnivel->query($queryp); echo $queryp . '</br>';

foreach ($repartos as $idtien => $valores) {
$cant=$valores['cantidad'];$smin=$valores['stockmin'];	
$queryp= "INSERT INTO repartir (id_articulo,id_tienda,cantidad,stockmin) value ($idarticulo_new,$idtien,$cant,$smin);";	
$dbnivel->query($queryp); echo $queryp . '</br>';
}



?>