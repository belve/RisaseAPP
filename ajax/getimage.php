<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");
$codigos=array();
$files=array();

if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id_proveedor, refprov from articulos where codbarras=$codbarras";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$id_proveedor=$row['id_proveedor'];
$refprov=$row['refprov'];
};



$queryp= "select codbarras from articulos where id_proveedor=$id_proveedor AND refprov='$refprov' AND codbarras != $codbarras;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$codigos[$row['codbarras']]=1;
};



$donde=$pathimages . $codbarras . "-*.jpg";
$list = glob($donde);
if(count($list)>0){foreach ($list as $point => $codi){
#$cod=str_replace($pathimages, '', $codi);
#$codigs=explode('-', $cod);
$files[]=$codi;	
}}




if (count($codigos)>0){foreach($codigos as $codbarras => $point){

$donde=$pathimages . $codbarras . "-*.jpg";
$list = glob($donde);
if(count($list)>0){foreach ($list as $point => $codi){
#$cod=str_replace($pathimages, '', $codi);
#$codigs=explode('-', $cod);
$files[]=$codi;	
}}	
	
}}


if(array_key_exists(0, $files)){
echo $files[0];
}else{
echo $pathimages . "nodisp.jpg";	
}


?>