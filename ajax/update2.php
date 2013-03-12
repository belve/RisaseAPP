<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); };
require_once("../db.php");
require_once("../variables.php");

$campos=array();
$campos=$_GET['campos'];


$modificos="";
foreach ($campos as $camp => $value){
	$modificos .=" $camp = '$value',";
}
$modificos=substr($modificos,0,strlen($modificos)-1);

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "update $tabla set $modificos where id=$id;"; echo $queryp;
$dbnivel->query($queryp);

if (!$dbnivel->close()){die($dbnivel->error());};



?>