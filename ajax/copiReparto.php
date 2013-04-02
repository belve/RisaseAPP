<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

if (!$dbnivel->open()){die($dbnivel->error());};

$articulos=substr($idarticulo_new, 0,strlen($idarticulo_new)-1);
$copios=explode(',',$idarticulo_new);

$insertos=array();$updates=array();

$queryp= "select id_tienda, cantidad, stockmin from repartir where id_articulo=$idarticulo;";
$dbnivel->query($queryp); 
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
$dbnivel->query($queryp); 
$valinsert=substr($valinsert, 0,strlen($valinsert)-1);
$queryp= "INSERT INTO repartir (id_articulo,id_tienda,cantidad,stockmin) values $valinsert;";	
$dbnivel->query($queryp);


$suma=array();;
$queryp= "select id_articulo, id_tienda, cantidad, stockmin,
(select id_proveedor from articulos where articulos.id=repartir.id_articulo) as idprov,
(select codbarras from articulos where articulos.id=repartir.id_articulo) as codbarras,  
(select id from pedidos where pedidos.id_tienda=repartir.id_tienda AND pedidos.id_articulo=repartir.id_articulo ORDER BY id DESC limit 1) as idp, 
(select estado from pedidos where pedidos.id_tienda=repartir.id_tienda AND pedidos.id_articulo=repartir.id_articulo ORDER BY id DESC limit 1) as estado, 
(select tip from pedidos where pedidos.id_tienda=repartir.id_tienda AND pedidos.id_articulo=repartir.id_articulo ORDER BY id DESC limit 1) as tip
 from repartir where id_articulo IN ($articulos);";
 
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
$idp=$row['idp'];$estado=$row['estado'];$tip=$row['tip'];$ida=$row['id_articulo'];$provs[$ida]=$row['idprov'];$codbarras[$ida]=$row['codbarras'];

if(($idp)&&($tip==1)&&($estado!='F')){$updates[$idp]=$row['cantidad'];if(array_key_exists($ida, $suma)){$suma[$ida]=$suma[$ida]+$row['cantidad'];}else{$suma[$ida]=$row['cantidad'];};};
if(!$idp){$insertos[$ida][$row['id_tienda']]=$row['cantidad'];if(array_key_exists($ida, $suma)){$suma[$ida]=$suma[$ida]+$row['cantidad'];}else{$suma[$ida]=$row['cantidad'];};};

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
$dbnivel->query($queryp); 
}

$valinsert="";$cuales="";
if(count($updates)>0){
foreach ($updates as $idp => $cant){
$valinsert .="WHEN $idp THEN $cant ";
$cuales.=$idp . ",";
}
$valinsert=substr($valinsert, 0,strlen($valinsert)-1);$cuales=substr($cuales, 0,strlen($cuales)-1);
$queryp="UPDATE pedidos SET cantidad = CASE id $valinsert END WHERE id IN ($cuales);";
$dbnivel->query($queryp);
}

if (!$dbnivel->close()){die($dbnivel->error());};
echo json_encode($suma);

?>