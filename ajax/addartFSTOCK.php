<?php
$id_proveedor="";$id_grupo="";$id_subgrupo="";$id_color="";$codigo="";$pvp="";$desde="";$hasta="";$temporada="";$hago="";
$yalistados="";
$detalles="";
$comentarios="";
$ord=1;
$tab=1;
$arts=array();
$vals=array();
	
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$options="";$forsync="";
require_once("../functions/listador.php");
    if($yalistados){$options .=" OR id IN ($yalistados)"; };
	
	$queryp= "select * from articulos where $options;"; 
	
	$dbnivel->query($queryp);
	while ($row = $dbnivel->fetchassoc()){
	$cd=$row['codbarras']; $id_articulo=$row['id']; $pvp=$row['pvp']; $pvori=$row['pvp'];
	
	$g=(substr($cd,0,1))*1; $s=(substr($cd,1,1))*1;$c=(substr($cd,4))*1;
		
	$arts[$g][$s][$c][$id_articulo]=$cd;	
	}

if (!$dbnivel->close()){die($dbnivel->error());};




if(count($arts)>0){
ksort($arts);$ccc=0;
foreach ($arts as $g => $sub) {ksort($sub); foreach ($sub as $s => $cods) {ksort($cods); foreach ($cods as $co => $art) { foreach ($art as $id => $codbarras) {
	$vals[$ccc]=$codbarras;$ccc++;
}}}}}

echo json_encode($vals);


?>