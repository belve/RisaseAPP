<?php
$id_proveedor="";$id_grupo="";$id_subgrupo="";$id_color="";$codigo="";$pvp="";$desde="";$hasta="";$temporada="";$hago="";

$detalles="";
$comentarios="";
$ord=1;
$tab=1;

	
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$options="";$forsync="";
require_once("../functions/listador.php");

	$queryp= "select * from articulos where $options";
	$listado="";
	
	$dbnivel->query($queryp);
	while ($row = $dbnivel->fetchassoc()){
	$codbarras=$row['codbarras']; $id_articulo=$row['id']; $pvp=$row['pvp']; $pvori=$row['pvp'];
		
	$arts[$id_articulo]="$codbarras|$pvori|$pvp";	
	}
		
	






if (!$dbnivel->close()){die($dbnivel->error());};


echo json_encode($arts);


?>