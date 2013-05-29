<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "update $tabla set nombre='$name' where id=$id;";
$dbnivel->query($queryp);

if (!$dbnivel->close()){die($dbnivel->error());};

if(array_key_exists($tabla, $tab_sync)){SyncModBD($queryp);};

?>