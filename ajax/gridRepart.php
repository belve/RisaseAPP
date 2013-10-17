<?php
set_time_limit(0);

$listador="";$comentarios="";$detalles="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");require_once("../functions/gridreparto.php");


$id="";
$dart=array();
$grid=array();

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "delete from pedidos where cantidad=0;";
$dbnivel->query($queryp);

if($listador==1){
$options="";
$tab=1;$ord=1;
require_once("../functions/listador.php"); 
$quer2= "select id from articulos where $options;";	
}
elseif($listador==2)
{
	
$quer2= "select distinct id_articulo as id from pedidos where tip=1 AND (estado='-' or estado='A');";

}else{
$quer2= "select id from articulos where codbarras=$codbarras;";
}


$dtiendas=array();


$idsabuscar="";
$dbnivel->query($quer2); 
while ($row = $dbnivel->fetchassoc()){$idsabuscar .=$row['id'] . ",";};
$idsabuscar=substr($idsabuscar,0,strlen($idsabuscar)-1);


$queryp= "select id, codbarras, refprov, stock, SUBSTRING(codbarras,1,1) as g, SUBSTRING(codbarras,2,1) as sg,
(select sum(cantidad) from pedidos where pedidos.id_articulo=articulos.id AND (estado != 'F' AND estado !='T') ) as penrepartir
from articulos where id IN ($idsabuscar) ORDER BY g, sg, codigo;";



$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
$dart[$row['id']]['codbarras']=$row['codbarras'];	
$dart[$row['id']]['refprov']=$row['refprov'];	
$dart[$row['id']]['stock']=$row['stock']; 			
$dart[$row['id']]['rep']=$row['penrepartir']; 	
}	



$queryp= "select distinct id_articulo, id_tienda from pedidos where id_articulo IN ($idsabuscar) AND tip=1 AND estado LIKE 'F';";



$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
if(array_key_exists($row['id_tienda'], $EQtiendas2)){ 
$columna=$EQtiendas2[$row['id_tienda']];	
$dart[$row['id_articulo']]['tsel'][$columna]=1;	
}}	







$queryp= "select 
id_articulo, 
cantidad, 
stockmin, 
id_tienda
from repartir where id_articulo IN ($idsabuscar);";


$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$grid[$row['id_articulo']][$row['id_tienda']]['cantidad']=$row['cantidad'];	
$grid[$row['id_articulo']][$row['id_tienda']]['alarma']=$row['stockmin'];
$grid[$row['id_articulo']][$row['id_tienda']]['id']=$row['id_tienda'];	
}	
	




	
$valores=GenerateGrid($grid,$ultifila,$dart);








if (!$dbnivel->close()){die($dbnivel->error());};
echo json_encode($valores);

?>
