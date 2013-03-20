<?php


foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");




if (!$dbnivel->open()){die($dbnivel->error());};

$htmlGrupo="<option value=''></option>";
$queryp= "select id, nombre from subgrupos where id_grupo=$id ORDER BY id ASC;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$id=$row['id'];$nombre=$row['nombre'];
	$htmlGrupo .="<option value='$id'>$nombre</option>";	
}


echo $htmlGrupo;
?>