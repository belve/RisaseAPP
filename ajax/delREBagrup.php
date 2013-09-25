<?php
$debug=0;
$arts=array();

#print_r($_GET);

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};



$queryp= "select tiendas from rebajas where id=$id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$tisel2=$row['tiendas'];};

$queryp= "DELETE FROM rebajas where id=$id;";
$dbnivel->query($queryp);if($debug){echo $queryp . "\n";};

	
$queryp1= "DELETE FROM det_rebaja where id_rebaja=$id;";
$dbnivel->query($queryp1);if($debug){echo $queryp . "\n";};


	
$vals['ok']=$id;	
echo json_encode($vals);
	
if (!$dbnivel->close()){die($dbnivel->error());};	
if($queryp1){SyncModBD_T($queryp1,$tisel2);};	

	
?>	