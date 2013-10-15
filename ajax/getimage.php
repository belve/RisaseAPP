<?php
$nodet="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

$codigos[$codbarras]=1;
$files=array();
$list=array();
$debug=1;

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


$grup=substr($codbarras, 0,2);
$listcodb=$codbarras;



$cord=array();

$queryp= "select codbarras from articulos where id_proveedor=$id_proveedor AND refprov='$refprov' AND codbarras like '$grup%' AND codbarras NOT IN ($codbarras);";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$codigos[$row['codbarras']]=1;
$nwc=$row['codbarras'];
$listcodb .=",$nwc";

$cd=$row['codbarras'];
$g=substr($cd,0,1);$sg=substr($cd,1,1);$c=substr($cd,4);
$cord[$g][$sg][$c]=$cd;

};
																												if($debug){echo $queryp; echo "<br><br>" ;  print_r($codigos); echo " <br><br>";};







$queryp= "select codbarras from articulos where refprov like '%$provsin' AND codbarras like '$grup%' AND codbarras NOT IN ($listcodb);";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	
$codigos[$row['codbarras']]=1;

$cd=$row['codbarras'];
$g=substr($cd,0,1);$sg=substr($cd,1,1);$c=substr($cd,4);
$cord[$g][$sg][$c]=$cd;


};
																												if($debug){echo $queryp; echo "<br><br>" ; print_r($codigos); echo " <br><br>";};


$cdg=array();
if(count($cord)>0){
ksort($cord);foreach ($cord as $gu => $subs) {ksort($subs);foreach ($subs as $sb => $ccs)	{ksort($ccs); foreach ($ccs as $cd => $codbar) {
$cdg[$codbar]=1;	
}}}}







if (count($codigos)>0){foreach($codigos as $codbarras => $point){

																												if($debug){echo "$codbarras <br>";};

$donde=$pathimages . $codbarras . "-*.[jJ][pP][gG]";															if($debug){echo "$donde <br>";};
$list = glob($donde); 
																												if($debug){print_r($list); echo " <br><br>";};
if(count($list)>0){foreach ($list as $point => $codi){
#$cod=str_replace($pathimages, '', $codi);
#$codigs=explode('-', $cod);
$files[]=$codi;	
}}	
	
}}

$files2['img']=$files;
$files2['cod']=$cdg;

if($nodet){
echo json_encode($files);	
}else{
echo json_encode($files2);
}

?>