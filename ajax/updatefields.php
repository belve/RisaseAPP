<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");
$campos=$_GET['campos'];

$equivalencias['empleados']['a']='nombre';
$equivalencias['empleados']['b']='apellido1';
$equivalencias['empleados']['c']='apellido2';
$equivalencias['empleados']['d']='trabajando';
$equivalencias['empleados']['e']='orden';

if (!$dbnivel->open()){die($dbnivel->error());};

foreach ($campos as $composicion => $value) {
$compos=explode('V',$composicion);
	
$queryp= "update $tabla set " . $equivalencias[$tabla][$compos[0]] . "='$value' where id=$compos[1];";
$dbnivel->query($queryp);
	
}




if (!$dbnivel->close()){die($dbnivel->error());};



?>