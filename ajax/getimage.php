<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");
$codigos=array();


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

print_r($codigos);

$donde=$pathimages . $codbarras . "-*.jpg";



$list = glob($donde);

if(count($list)>0){foreach ($list as $point => $codi){
$cod=str_replace($pathimages, '', $codi);
$codigs=explode('-', $cod);
$files[$codigs[0]]=1;	
}}


print_r($files);


#if (file_exists($donde)) {$ruta=$donde;} 

?>