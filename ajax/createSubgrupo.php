<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$id="";
$queryp= "select id from subgrupos where id_grupo=$g AND clave=$sg;";	
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$id=$row['id'];};

if(!$id){
	
$queryp= "select max(id) as id from subgrupos;";	
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$uid=$row['id']+1;};	
	
	
$queryp2= "INSERT INTO subgrupos (id,id_grupo,nombre,clave) VALUES ($uid,$g,'$nombre',$sg);";	
$dbnivel->query($queryp2);

$valores['lastid']=$uid;

if (!$dbnivel->close()){die($dbnivel->error());};
SyncModBD($queryp2);

}else{
	
$valores['error']='Codigo duplicado';	
}



echo json_encode($valores);

?>