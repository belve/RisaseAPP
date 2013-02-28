<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

if($pointer<0){
$queryp= "select * from $tabla ORDER BY id DESC limit 0,1;";	
}else{
	
if(($pointer>0)&&($tabla=='colores')){$pointer--;};

$queryp= "select * from $tabla ORDER BY id ASC limit $pointer,1;";
}


$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$valores[$row['id']]=$row['nombre'];};

if (!$dbnivel->close()){die($dbnivel->error());};



echo json_encode($valores);
