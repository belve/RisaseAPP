<?php
set_time_limit(0);
$debug=0;

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

if (!$dbnivel->open()){die($dbnivel->error());};

$articulos=substr($idarticulo_new, 0,strlen($idarticulo_new)-1);
$copios=explode(',',$idarticulo_new);

$insertos=array();$updates=array();

$queryp= "select id_tienda, cantidad, stockmin from repartir where id_articulo=$idarticulo;";
$dbnivel->query($queryp); if($debug==1){echo $queryp . "\n\n";};
while ($row = $dbnivel->fetchassoc()){
	
		$repartos[$row['id_tienda']]['cantidad']=$row['cantidad'];
		$repartos[$row['id_tienda']]['stockmin']=$row['stockmin'];


};




$valinsert="";$borros="";
foreach ($copios as $point => $idarticulo_new){if($idarticulo_new > 0){
	
foreach ($repartos as $idtien => $valores) {
$cant=$valores['cantidad'];$smin=$valores['stockmin'];	
$valinsert .="($idarticulo_new,$idtien,$cant,$smin),";
}			
$borros .=$idarticulo_new . ',';
}}



$borros=substr($borros, 0,strlen($borros)-1);
$queryp= "delete from repartir where id_articulo IN ($borros);";
$dbnivel->query($queryp); if($debug==1){echo $queryp . "\n\n";};
$valinsert=substr($valinsert, 0,strlen($valinsert)-1);
$queryp= "INSERT INTO repartir (id_articulo,id_tienda,cantidad,stockmin) values $valinsert;";	
$dbnivel->query($queryp); if($debug==1){echo $queryp . "\n\n";};


$suma=array();

$queryp= "select id, id_proveedor, codbarras from articulos where id IN ($articulos);";
$dbnivel->query($queryp);  if($debug==1){echo $queryp . "\n\n";};
while ($row = $dbnivel->fetchassoc()){
$provs[$row['id']]=$row['id_proveedor']; $codbarras[$row['id']]=$row['codbarras'];
}

$queryp= "select id, id_articulo, id_tienda, tip, estado from pedidos where id_articulo IN ($articulos) ORDER BY id DESC;";
$dbnivel->query($queryp);  if($debug==1){echo $queryp . "\n\n";};
while ($row = $dbnivel->fetchassoc()){
$dpedidos[$row['id_articulo']][$row['id_tienda']]['id']=$row['id'];
$dpedidos[$row['id_articulo']][$row['id_tienda']]['tip']=$row['tip'];
$dpedidos[$row['id_articulo']][$row['id_tienda']]['estado']=$row['estado'];
}





$queryp= "select id_articulo, id_tienda, cantidad, stockmin from repartir where id_articulo IN ($articulos);";
$dbnivel->query($queryp);  if($debug==1){echo $queryp . "\n\n";};
while ($row = $dbnivel->fetchassoc()){
$ida=$row['id_articulo'];
$idtt=$row['id_tienda'];

$dpart=$dpedidos[$ida];

if(array_key_exists($idtt, $dpart)){
$estado=$dpart[$idtt]['estado'];
$tip=$dpart[$idtt]['tip'];
$idp=$dpart[$idtt]['id'];
}else{
$idp=0;	
}

if(($idp)&&($tip==1)&&($estado!='F')){
	$updates[$idp]=$row['cantidad'];
	if(array_key_exists($ida, $suma)){
		$suma[$ida]=$suma[$ida]+$row['cantidad'];}else{$suma[$ida]=$row['cantidad'];};};
if(!$idp){
	$insertos[$ida][$idtt]=$row['cantidad'];
	if(array_key_exists($ida, $suma)){
		$suma[$ida]=$suma[$ida]+$row['cantidad'];}else{$suma[$ida]=$row['cantidad'];};};

};





$valinsert="";
if(count($insertos)>0){
foreach ($insertos as $idarticulo => $valores){foreach($valores as $idtien => $cant) {
$fecha=date('Y') . "/" . date('m') . "/" . date('d');
$prov=$provs[$idarticulo];		
$codbarra=$codbarras[$idarticulo];

$grupo=substr($codbarra, 0,1);
$subgrupo=substr($codbarra, 1,1);
$code=substr($codbarra, 4);
	
$valinsert .="($idarticulo,$idtien,$cant,1,'$fecha',$prov,$grupo,$subgrupo,$code),";
}}
$valinsert=substr($valinsert, 0,strlen($valinsert)-1);
$queryp="INSERT INTO pedidos (id_articulo,id_tienda,cantidad,tip,fecha,prov,grupo,subgrupo,codigo) values $valinsert;";
$dbnivel->query($queryp); if($debug==1){echo $queryp . "\n\n";};
}

$valinsert="";$cuales="";
if(count($updates)>0){
foreach ($updates as $idp => $cant){
$valinsert .="WHEN $idp THEN $cant ";
$cuales.=$idp . ",";
}
$valinsert=substr($valinsert, 0,strlen($valinsert)-1);$cuales=substr($cuales, 0,strlen($cuales)-1);
$queryp="UPDATE pedidos SET cantidad = CASE id $valinsert END WHERE id IN ($cuales);";
$dbnivel->query($queryp); if($debug==1){echo $queryp . "\n\n";};
}

if (!$dbnivel->close()){die($dbnivel->error());};
echo json_encode($suma);

?>