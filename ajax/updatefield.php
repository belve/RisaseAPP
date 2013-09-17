<?php
require_once("../db.php");
require_once("../variables.php");
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};



if (!$dbnivel->open()){die($dbnivel->error());};

$value=str_replace(',','.',$value);
	
$queryp= "update $tabla set $campo='$value' where id=$id;";
$dbnivel->query($queryp);
	

echo $queryp;




if (!$dbnivel->close()){die($dbnivel->error());};

if(array_key_exists($tabla, $tab_sync)){SyncModBD($queryp);};



?>