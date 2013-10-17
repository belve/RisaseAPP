<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$id="";
#############3 saco lo que se esta repartiendo de ese articulo no finalizado este en reparto o pedido
$queryp="select id, stock, refprov, (select sum(cantidad) from pedidos where estado != 'F' AND pedidos.id_articulo=articulos.id) as rep from articulos where codbarras=$cod;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$valores['ida']=$row['id'];$id=$row['id'];
$valores['sto']=$row['stock'] - $row['rep'];
$valores['sto2']=$row['stock'];			
$valores['rep']='';
$valores['nom']=$cod . " / " . $row['refprov'];
$valores['dr']=$row['rep'];
if(!$valores['dr']){$valores['dr']=0;};
}


if (!$dbnivel->close()){die($dbnivel->error());};

if(!$id){
$valores['error']='Codigo no encontrado';
}

echo json_encode($valores);

?>