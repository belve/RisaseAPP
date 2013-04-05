<?php
require_once("../db.php");
require_once("../variables.php");
require_once("../functions/pedidos.php");

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

if($action==1){
$valores['html']=pedipent($tip);	
}

if($action==3){
$valores['html']=listagrup($tip,$id);	
}

if($action==2){
$valores['html']=agrupaciones($tip,$agrupar);	
}


echo json_encode($valores);
?>
