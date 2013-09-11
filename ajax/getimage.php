<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

$codigos[$codbarras]=1;
$files=array();
$list=array();
$debug=0;

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
																												if($debug){echo $queryp; echo "<br><br>" ; echo "$id_proveedor $refprov $proveedor <br><br>";};



$provsin=str_replace($proveedor,'',$refprov);




$queryp= "select codbarras from articulos where refprov like '%$provsin' AND codbarras NOT IN ($listcodb);";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$codigos[$row['codbarras']]=1;
};
																												if($debug){echo $queryp; echo "<br><br>" ; print_r($codigos); echo " <br><br>";};





$listcodb=$codbarras;
$queryp= "select codbarras from articulos where id_proveedor=$id_proveedor AND refprov='$refprov' AND codbarras != $codbarras;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$codigos[$row['codbarras']]=1;
$nwc=$row['codbarras'];
$listcodb .=",$nwc";
};
																												if($debug){echo $queryp; echo "<br><br>" ;  print_r($codigos); echo " <br><br>";};





if (count($codigos)>0){foreach($codigos as $codbarras => $point){

																												if($debug){echo "$codbarras <br>";};

$donde=$pathimages . $codbarras . "-*.[jJ][pP][gG]";
$list = glob($donde);
																												if($debug){print_r($list); echo " <br><br>";};
if(count($list)>0){foreach ($list as $point => $codi){
#$cod=str_replace($pathimages, '', $codi);
#$codigs=explode('-', $cod);
$files[]=$codi;	
}}	
	
}}


echo json_encode($files);


?>