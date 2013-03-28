<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");require_once("../functions/gridreparto.php");

$id="";


if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id from articulos where codbarras=$codbarras";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$id=$row['id'];};
if (!$dbnivel->close()){die($dbnivel->error());};


$dtiendas=array();$ultifila++;
$valores=GenerateGrid($id,$dtiendas,$ultifila);

echo json_encode($valores);

?>
