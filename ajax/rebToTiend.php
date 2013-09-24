<?php
$debug=0;


foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$arts=$_GET['arts'];
	
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};



$queryp= "UPDATE rebajas set tiendas='$tisel' where id=$id_rebaja;";
$dbnivel->query($queryp);if($debug){echo $queryp . "\n";};




if(count($arts)>0){
	
$queryp1= "DELETE FROM det_rebaja where id_rebaja=$id_rebaja;";
$dbnivel->query($queryp1);if($debug){echo $queryp . "\n";};
	
$artics="";
foreach ($arts as $idart => $precio) {$artics .="($id_rebaja,$idart,$precio,'$fini','$ffin'),";};	

$artics=substr($artics, 0, strlen($artics)-1);

$queryp= "INSERT INTO det_rebaja (id_rebaja,id_articulo,precio,fecha_ini,fecha_fin) VALUES $artics;";
$dbnivel->query($queryp); if($debug){echo $queryp . "\n";};
	

	
	
}
	
$vals['ok']=$id_rebaja;	
echo json_encode($vals);
	
if (!$dbnivel->close()){die($dbnivel->error());};	
SyncModBD_T($queryp1,$tisel);	
SyncModBD_T($queryp,$tisel);	
?>	