<?php

$arts=array();
$tsel=array();

$arts=$_GET['arts'];
$tsel=$_GET['tsel'];


$alm=$_GET['alm'];
$bd=$_GET['bd'];
$fecha=date('Y') . "-" . date('m') . "-" . date('d');

require_once("../db.php");
require_once("../variables.php");

if(count($tsel)>0){if(count($arts)>0){

if (!$dbnivel->open()){die($dbnivel->error());};	
	
$cods="";	
foreach ($arts as $ida => $vals) {$cods.=$ida . ",";}	
$cods=substr($cods, 0,-1);	

$queryp= "select id, codbarras from articulos where codbarras IN ($cods);"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$idartis[$row['codbarras']]=$row['id'];}
	
	
$queryp="INSERT INTO fij_stock (id_tienda,id_articulo,fijo,suma,alm,bd,fecha) VALUES ";	

print_r($arts);	
foreach ($tsel as $key => $idt) { foreach ($arts as $ida => $vals) {
$ida=$idartis[$ida];
$fijo="";if(array_key_exists('f', $vals)){$fijo=$vals['f'];};		
$suma="";if(array_key_exists('s', $vals)){$suma=$vals['s'];};		

$queryp .="($idt,$ida,'$fijo','$suma','$alm','$bd','$fecha'),";	
}}	
	
$queryp=substr($queryp,0,-1);
$queryp .=";";



	$dbnivel->query($queryp); 
if (!$dbnivel->close()){die($dbnivel->error());};	

}}

$valst[0]="Stocks enviados correctamente";
	
echo json_encode($valst);
?>
