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
$queryp="INSERT INTO fij_stock (id_tienda,id_articulo,fijo,suma,alm,bd,fecha) VALUES ";	
	
foreach ($tsel as $key => $idt) { foreach ($arts as $ida => $vals) {
$fijo=$vals['f'];		
$suma=$vals['s'];
$queryp .="($idt,$ida,'$fijo','$suma','$alm','$bd','$fecha'),";	
}}	
	
$queryp=substr($queryp,0,-1);
$queryp .=";";


if (!$dbnivel->open()){die($dbnivel->error());};
	$dbnivel->query($queryp); 
if (!$dbnivel->close()){die($dbnivel->error());};	

}}

$valst[0]="Stocks enviados correctamente";
	
echo json_encode($valst);
?>
