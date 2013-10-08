<?php
require_once("../db.php");
require_once("../variables.php");
require_once("../functions/pedidos.php");

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};


if($action==1){

$filtro=str_replace('|', '%', $filtro);	
$valores=agrup_estado($tip,$est,$filtro);	
}


if($action==2){
$valores=change_estado($idag,$newest);	
}

echo json_encode($valores);
?>
