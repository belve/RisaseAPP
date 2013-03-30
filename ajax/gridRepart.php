<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");require_once("../functions/gridreparto.php");


$id="";
$dart=array();

if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id, refprov, stock from articulos where codbarras=$codbarras";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$id=$row['id'];

$dart[$id]['codbarras']=$codbarras;	
$dart[$id]['refprov']=$row['refprov'];	
$dart[$id]['stock']=$row['stock'];		

}
if (!$dbnivel->close()){die($dbnivel->error());};


$dtiendas=array();$ultifila++;
if($id){
$valores=GenerateGrid($id,$dtiendas,$ultifila,$dart);
}else{
$valores['error']="Articulo no encontrado";};

echo json_encode($valores);

?>
