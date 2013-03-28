<?php
require_once("../db.php");
require_once("../variables.php");
$idrep="";$estado="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

if (!$dbnivel->open()){die($dbnivel->error());};


if($idrep){

$queryp= "update detreparto set estado='$estado' where id_reparto=$idrep";
$dbnivel->query($queryp);
$queryp= "update repartos set estado='$estado' where id=$idrep";
$dbnivel->query($queryp); echo $queryp;

}





if (!$dbnivel->close()){die($dbnivel->error());};



?>