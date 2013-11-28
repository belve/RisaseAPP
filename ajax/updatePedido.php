<?php
require_once("../db.php");
require_once("../variables.php");

$idp="";$ida="";$idg="";$ida="";$cant=0;
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};



if (!$dbnivel->open()){die($dbnivel->error());};

$idgs=array();$borr=array();
if($idg=='GRID'){
$queryp= "select agrupar from pedidos where id_tienda=$idt AND tip=2 AND estado='A';;";
$dbnivel->query($queryp);echo "\n" . $queryp;
while ($row = $dbnivel->fetchassoc()){$idg=$row['agrupar'];};

$queryp= "select id, agrupar from pedidos where id_tienda=$idt AND tip=2 AND estado='A' AND id_articulo='$ida';";
$dbnivel->query($queryp);echo "\n" . $queryp;
while ($row = $dbnivel->fetchassoc()){$idgs[$row['id']]=$row['agrupar']; if(count($idgs)>1){$borr[$row['id']]=1;}else{ $idp=$row['id']; };   };	

if(count($borr)>0){foreach ($borr as $idpb => $pp){
$queryp= "delete from pedidos where id=$idpb;";
$dbnivel->query($queryp);echo "\n" . $queryp;		
}}
	
}


if(!$idp){
$queryp= "select id from pedidos where agrupar='$idg' AND id_tienda='$idt' AND id_articulo='$ida';";
$dbnivel->query($queryp);echo "\n" . $queryp;
while ($row = $dbnivel->fetchassoc()){$idp=$row['id'];};	
}
if ($idp){

$queryp= "select id from pedidos where agrupar='$idg' AND id_tienda='$idt' AND id_articulo='$ida' AND id NOT IN ($idp);";
$dbnivel->query($queryp);echo "\n" . $queryp;
while ($row = $dbnivel->fetchassoc()){
	$idborr=$row['id'];
	$queryp= "delete from pedidos where id=$idborr;";
	$dbnivel->query($queryp);
};	
	
	
$queryp= "update pedidos set cantidad='$cant' where id=$idp;";
$dbnivel->query($queryp);echo "\n" . $queryp;
}else{

$queryp= "select estado, tip, fecha from agrupedidos where id='$idg';";
$dbnivel->query($queryp);echo "\n" . $queryp;
while ($row = $dbnivel->fetchassoc()){$estado=$row['estado'];$fecha=$row['fecha']; $tip=$row['tip'];};
if($estado=='P'){$estado='-';};
	
if($cant>0){
$queryp= "INSERT INTO pedidos (id_articulo,id_tienda,cantidad,estado,tip,agrupar,fecha) values ('$ida','$idt','$cant','$estado','$tip','$idg','$fecha');";
$dbnivel->query($queryp);echo "\n" . $queryp;	
}	
}	





if (!$dbnivel->close()){die($dbnivel->error());};

#if(array_key_exists($tabla, $tab_sync)){SyncModBD($queryp);};



?>