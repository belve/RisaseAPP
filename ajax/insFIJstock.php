<?php

$arts=array();
$tsel=array();

$arts=$_GET['arts'];
$tsel=$_GET['tsel'];


require_once("../db.php");
require_once("../variables.php");

if(count($tsel)>0){if(count($arts)>0){
$queryp="INSERT INTO fij_stock (id_tienda,id_articulo,fijo,suma) VALUES ";	
	
foreach ($tsel as $key => $idt) { foreach ($arts as $ida => $vals) {
$fijo=$vals['f'];		
$suma=$vals['s'];
$queryp .="($idt,$ida,'$fijo','$suma'),";	
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
