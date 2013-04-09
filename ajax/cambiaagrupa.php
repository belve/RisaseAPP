<?php


foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

if($oldG){$vieja="agrupar='$oldG'";}else{$vieja="(agrupar='' OR agrupar IS NULL)";};


if (!$dbnivel->open()){die($dbnivel->error());};

$queryp="update pedidos set agrupar='$newG' WHERE tip=$tip AND estado='-' AND $vieja AND id_articulo IN ($selecion);";	
$dbnivel->query($queryp); echo $queryp;




if (!$dbnivel->close()){die($dbnivel->error());};



?>