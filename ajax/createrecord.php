<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select * from $tabla order by id DESC limit 1;";	
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$newid=$row['id']+1;};

$queryp= "INSERT INTO $tabla (id) VALUES ($newid);";	
$dbnivel->query($queryp);

$valores['lastid']=$newid;


if (!$dbnivel->close()){die($dbnivel->error());};

if(array_key_exists($tabla, $tab_sync)){SyncModBD($queryp);};


echo json_encode($valores);