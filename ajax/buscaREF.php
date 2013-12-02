<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select codbarras, substring(codbarras,1,1) as G, substring(codbarras,2,1) as SG, substring(codbarras,5) as COD from articulos where refprov LIKE '%$ref%' ORDER BY G, SG, COD limit 15;";
$html="";
$dbnivel->query($queryp);$c=1;
while ($row = $dbnivel->fetchassoc()){$c++;
$codbarras=$row['codbarras'];
if($c>15){$col="style='background-color:red;'";}else{$col="";};
$html .="<div class='refPcomb' id='$codbarras' $col onclick='selREF(this.id)'>$codbarras</div>";	
}



if (!$dbnivel->close()){die($dbnivel->error());};


$valores['html']=$html;

echo json_encode($valores);

?>