<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select codbarras from articulos where refprov LIKE '%$ref%';";
$html="";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$codbarras=$row['codbarras'];
$html .="<div class='refPcomb' id='$codbarras' onclick='selREF(this.id)'>$codbarras</div>";	
}



if (!$dbnivel->close()){die($dbnivel->error());};


$valores['html']=$html;

echo json_encode($valores);

?>