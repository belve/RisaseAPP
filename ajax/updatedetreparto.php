<?php
$iddetr="";$idrept="";$idarti="";$columna="";$alarma="";$cant="";$stock="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

$tip=0;$estado="";

if (!$dbnivel->open()){die($dbnivel->error());};


$idtiendae=$EQtiendas[$columna];




$queryp= "SELECT id_proveedor, codbarras from articulos WHERE id=$idarti;";
$dbnivel->query($queryp); echo $queryp;
while ($row = $dbnivel->fetchassoc()){$prov=$row['id_proveedor'];$codbarra=$row['codbarras'];};
$fecha=date('Y') . "/" . date('m') . "/" . date('d');
$grupo=substr($codbarra, 0,1);
$subgrupo=substr($codbarra, 1,1);
$code=substr($codbarra, 4);	


if(!$iddetr){
$queryp= "SELECT id_articulo from repartir WHERE id_articulo=$idarti AND id_tienda=$idtiendae;";
$dbnivel->query($queryp); echo $queryp;
while ($row = $dbnivel->fetchassoc()){$iddetr=$row['id_articulo'];};
}	
	

	
	
if($iddetr){
	
$queryp= "SELECT id, tip, estado from pedidos WHERE id_articulo=$idarti AND id_tienda=$idtiendae ORDER by id DESC limit 1;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$tip=$row['tip'];$estado=$row['estado'];$idpedido=$row['id'];};	
	
	
if($cant){	
$queryp= "update repartir set cantidad=$cant, stockmin=$alarma where id_articulo=$idarti";
$dbnivel->query($queryp);



if($tip==0){
	

	
$queryp= "INSERT INTO pedidos (id_articulo,id_tienda,cantidad,tip,fecha,prov,grupo,subgrupo,codigo) values ($idarti,$idtiendae,$cant,1,'$fecha',$prov,$grupo,$subgrupo,$code);";$dbnivel->query($queryp);echo $queryp;	
}elseif(($tip==1)AND($estado != 'F')){
$queryp= "UPDATE pedidos set cantidad=$cant where id=$idpedido;";$dbnivel->query($queryp);echo $queryp;	
}


}else{
$queryp= "update repartir set stockmin=$alarma where id_articulo=$idarti";
$dbnivel->query($queryp);	
}
}else{



$queryp= "INSERT INTO repartir (id_articulo,id_tienda,cantidad,stockmin) values ($idarti,$idtiendae,$cant,$alarma);";
$dbnivel->query($queryp);echo $queryp;
$queryp= "INSERT INTO pedidos (id_articulo,id_tienda,cantidad,tip,fecha,prov,grupo,subgrupo,codigo) values ($idarti,$idtiendae,$cant,1,'$fecha',$prov,$grupo,$subgrupo,$code);";$dbnivel->query($queryp);echo $queryp;	


}


	





if (!$dbnivel->close()){die($dbnivel->error());};



?>