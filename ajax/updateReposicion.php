<?php
require_once("../db.php");
require_once("../variables.php");
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};



if (!$dbnivel->open()){die($dbnivel->error());};


$do="";
$queryp= "SELECT id from reposiciones WHERE ida=$id;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$do=$row['id'];}

if($do){	
$queryp= "update reposiciones set repo='$nrep' where ida=$id;";
$dbnivel->query($queryp); 
echo $dbnivel->error() . "\n";	
echo $queryp . "\n";
}else{
$queryp= "INSERT INTO reposiciones (ida,temp,repo) VALUES ($id,'$tmp','$nrep');";
$dbnivel->query($queryp); 
echo $dbnivel->error() . "\n";	
echo $queryp . "\n";	
}



$queryp= "update articulos set stock='$nstock' where id=$id;";
$dbnivel->query($queryp); 
echo $dbnivel->error() . "\n";	
echo $queryp . "\n";

if($nstock>0){
$queryp= "update articulos set congelado=0 where id=$id;";
$dbnivel->query($queryp); 
echo $dbnivel->error() . "\n";	
echo $queryp . "\n";	
SyncModBD($queryp);	
}



if (!$dbnivel->close()){die($dbnivel->error());};





?>