<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$borros=array();
$queryp= "select id from empleados where (nombre ='' OR nombre IS NULL) and (apellido1='' OR apellido1 IS NULL) and (apellido2='' OR apellido2 IS NULL);";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$borros[]=$row['id'];};
if(count($borros)>0){foreach($borros as $key => $id){
$queryp= "delete from empleados where id=$id;";
$dbnivel->query($queryp);
SyncModBD($queryp);	
}}




$queryp= "select * from tiendas where id=$id";



$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	
	$valores[1]=$row['id_tienda'];
	$valores[2]=$row['nombre'];
	$valores[3]=$row['cp'];
	$valores[4]=$row['direccion'];
	$valores[5]=$row['poblacion'];
	$valores[6]=$row['ciudad'];
	$valores[7]=$row['provincia'];
	$valores[8]=$row['telefono'];
	$valores[9]=$row['activa'];
	
	
	
};

if (!$dbnivel->close()){die($dbnivel->error());};



echo json_encode($valores);