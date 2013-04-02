<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />

</head>

<body>



<?php

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

$pendientes=array();$html="";

if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "SELECT id_articulo, sum(cantidad) as rep, 
(select codbarras from articulos where articulos.id=pedidos.id_articulo) as codbarras, 
(select refprov from articulos where articulos.id=pedidos.id_articulo) as refprov 
from pedidos WHERE tip=$tip AND estado='-' AND (agrupar='' or agrupar='null') GROUP BY id_articulo ORDER BY prov, fecha;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
$ref=$row['codbarras'] . " / " . $row['refprov'];
$rep=$row['rep'];

$html.= "
<div class='pedPen'>
<div class='pedPen_ART'>$ref</div>
<div class='pedPen_REP'>$rep</div>
</div>
";	

	
};



if (!$dbnivel->close()){die($dbnivel->error());};



?>


<?php echo $html; ?>

