<?php
$iddetr="";$idrept="";$idarti="";$columna="";$alarma="";$cant="";$stock="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

if (!$dbnivel->open()){die($dbnivel->error());};


$idtiendae=$EQtiendas[$columna];

if(!$iddetr){
$queryp= "SELECT id from detreparto WHERE id_reparto=$idrept AND id_articulo=$idarti AND id_tienda=$idtiendae;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$iddetr=$row['id'];};
}	
	
if($iddetr){
if($cant){	
$queryp= "update detreparto set cantidad=$cant, stockmin=$alarma where id=$iddetr";
$dbnivel->query($queryp);
$queryp= "update articulos set stock=$stock where id=$idarti";$dbnivel->query($queryp);echo $queryp;
}else{
$queryp= "update detreparto set stockmin=$alarma where id=$iddetr";
$dbnivel->query($queryp);	
}
}else{



$queryp= "INSERT INTO detreparto (id_reparto,id_articulo,id_tienda,cantidad,stockmin,estado) values ($idrept,$idarti,$idtiendae,$cant,$alarma,'');";
$dbnivel->query($queryp);echo $queryp;
$queryp= "update articulos set stock=$stock where id=$idarti";$dbnivel->query($queryp);	
}


	





if (!$dbnivel->close()){die($dbnivel->error());};



?>