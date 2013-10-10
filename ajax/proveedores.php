<?php
$noborro="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

if($pointer == "fin"){
$queryp= "select * from proveedores order by id DESC limit 1;";	
}else{
$queryp= "select * from proveedores where id=$pointer";
}


$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	
	$valores[1]=$row['id'];
	$valores[2]=$row['nombre'];
	$valores[3]=$row['cif'];
	$valores[4]=$row['direccion'];
	$valores[5]=$row['cp'];
	$valores[6]=$row['poblacion'];
	$valores[7]=$row['provincia'];
	$valores[8]=$row['contacto'];
	$valores[9]=$row['telefono'];
	$valores[10]=$row['fax'];
	$valores[11]=$row['email'];
	$valores[12]=$row['nomcorto'];
	$valores[13]=str_replace('.00', '', $row['dto1']);
	$valores[14]=str_replace('.00', '', $row['dto2']);
	
	
};

$syncsSQL=array();
if(!$noborro){
$borros=array();
$queryp= "select id from proveedores where nomcorto IS NULL";	
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$borros[]=$row['id'];};

if(count($borros)>0){foreach($borros as $key => $idb){
$queryp= "delete from proveedores where id=$idb;";	
$dbnivel->query($queryp);	$syncsSQL[]=$queryp;
}}
}

if (!$dbnivel->close()){die($dbnivel->error());};

if(count($syncsSQL)>0){SyncModBDARRAY($syncsSQL);};

echo json_encode($valores);