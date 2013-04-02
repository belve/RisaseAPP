<?php
$listador="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");require_once("../functions/gridreparto.php");


$id="";
$dart=array();
$grid=array();

if (!$dbnivel->open()){die($dbnivel->error());};



if($listador){
$options="";
require_once("../functions/listador.php"); 
$quer2= "select id from articulos where $options";	
}else{
$quer2= "select id from articulos where codbarras=$codbarras";
}



$dtiendas=array();


$queryp= "select id, codbarras, refprov, stock, 
(select sum(cantidad) from pedidos where pedidos.id_articulo=articulos.id AND estado NOT LIKE 'F') as penrepartir
from articulos where id IN ($quer2);";



$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$dart[$row['id']]['codbarras']=$row['codbarras'];	
$dart[$row['id']]['refprov']=$row['refprov'];	
$dart[$row['id']]['stock']=$row['stock'] -$row['penrepartir']; 			
}	
	


$queryp= "select 
id_articulo, 
cantidad, 
stockmin, 
id_tienda
from repartir where id_articulo IN ($quer2);";


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
