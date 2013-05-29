<?php
$noborro="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

if($pointer == "fin"){
$queryp= "select * from subgrupos order by id DESC limit 1;";	
}else{
$queryp= "select * from subgrupos where id=$pointer";
}


$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
		
	$valores[1]=$row['id'];
	$valores[2]=$row['id_grupo'];
	$valores[3]=$row['nombre'];
	$valores[4]=$row['clave'];
};


$syncsSQL=array();
if(!$noborro){
$borros=array();
$queryp= "select id from subgrupos where clave IS NULL";	
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$borros[]=$row['id'];};


if(count($borros)>0){foreach($borros as $key => $idb){
$queryp= "delete from subgrupos where id=$idb;";	
$dbnivel->query($queryp);	$syncsSQL[]=$queryp;
}}
}	

	
	if (!$dbnivel->close()){die($dbnivel->error());};




if(count($syncsSQL)>0){SyncModBDARRAY($syncsSQL);};



echo json_encode($valores);