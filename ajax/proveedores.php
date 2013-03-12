<?php
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
	
	
};

if (!$dbnivel->close()){die($dbnivel->error());};



echo json_encode($valores);