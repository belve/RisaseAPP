<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

$codigos[$codbarras]=1;
$files=array();

if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id_proveedor, 
(select nomcorto from proveedores where proveedores.id=articulos.id_proveedor) as proveedor, 
refprov from articulos where codbarras=$codbarras;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$id_proveedor=$row['id_proveedor'];
$refprov=$row['refprov'];
$proveedor=$row['proveedor'];
};
#echo $queryp;


$provsin=str_replace($proveedor,'',$refprov);

$listcodb=$codbarras;
$queryp= "select codbarras from articulos where id_proveedor=$id_proveedor AND refprov='$refprov' AND codbarras != $codbarras;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$codigos[$row['codbarras']]=1;
$nwc=$row['codbarras'];
$listcodb .=",$nwc";
};
#echo $queryp;


$queryp= "select codbarras from articulos where refprov like '%$provsin' AND codbarras NOT IN ($listcodb);";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$codigos[$row['codbarras']]=1;
};
#echo $queryp;




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
echo str_replace($pathimages, $urlimages, $files[0]);
}else{
echo $urlimages . "nodisp.jpg";	
}


?>