<?php
require_once("../db.php");
require_once("../variables.php");

$idp="";$ida="";$idg="";$ida="";$cant="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};



if (!$dbnivel->open()){die($dbnivel->error());};


if(!$idp){
$queryp= "select id from pedidos where agrupar='$idg' AND id_tienda='$idt' AND id_articulo='$ida';";
$dbnivel->query($queryp);echo "\n" . $queryp;
while ($row = $dbnivel->fetchassoc()){$idp=$row['id'];};	
}
if ($idp){
$queryp= "update pedidos set cantidad='$cant' where id=$idp;";
$dbnivel->query($queryp);echo "\n" . $queryp;
}else{

$queryp= "select estado, tip, fecha from agrupedidos where id='$idg';";
$dbnivel->query($queryp);echo "\n" . $queryp;
while ($row = $dbnivel->fetchassoc()){$estado=$row['estado'];$fecha=$row['fecha']; $tip=$row['tip'];};
if($estado=='P'){$estado='-';};
	
$queryp= "INSERT INTO pedidos (id_articulo,id_tienda,cantidad,estado,tip,agrupar,fecha) values ('$ida','$idt','$cant','$estado','$tip','$idg','$fecha');";
$dbnivel->query($queryp);echo "\n" . $queryp;	
	
}	






if (!$dbnivel->close()){die($dbnivel->error());};

#if(array_key_exists($tabla, $tab_sync)){SyncModBD($queryp);};



?>