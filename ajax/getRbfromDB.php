<?php


foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

	
require_once("../db.php");
require_once("../variables.php");$arts=array();


if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select 
id_articulo, precio, 
(select codbarras from articulos where id=id_articulo) as codbarras, 
(select pvp from articulos where id=id_articulo) as pvori from det_rebaja where id_rebaja=$id_rebaja;";

$listado="";

$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
$codbarras=$row['codbarras']; $id_articulo=$row['id_articulo']; $pvp=$row['precio']; $pvori=$row['pvori'];
$arts[$id_articulo]="$codbarras|$pvori|$pvp";

}

if (!$dbnivel->close()){die($dbnivel->error());};



echo json_encode($arts);
?>