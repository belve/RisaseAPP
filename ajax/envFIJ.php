<?php
$debug=1;
if($debug){echo "fijStock ________________________- \n\n";};
if($debug){print_r($_POST);}

$fijos=array();$hay=array();$ins="";

$fijos=$_POST['fijos'];


require_once("../db.php");
require_once("../variables.php");


if(count($fijos)>0){
	
	
$ids="";	$idts='';
foreach ($fijos as $ida => $tiends) {$ids.=$ida . ",";foreach ($tiends as $idt => $imports) {$idts.=$idt . ",";} };
$ids=substr($ids,0,-1);	
$idts=substr($idts,0,-1);	

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp="SELECT id, id_articulo, id_tienda from fij_pvp WHERE id_articulo IN ($ids) AND id_tienda IN ($idts); ";	
$dbnivel->query($queryp);	if($debug){echo $queryp . "\n";};
while ($row = $dbnivel->fetchassoc()){$hay[$row['id_tienda']][$row['id_articulo']]=$row['id'];};
	




foreach ($fijos as $ida => $tiends) { foreach ($tiends as $id_tiend => $importe) {
	

if(!array_key_exists($id_tiend, $hay)){

	if($importe > 0){
	$ins.="($ida,$id_tiend,'$importe'),";	
	}

}else{
		
	$new=$hay[$id_tiend];	
	if (!array_key_exists($ida, $new)){
		
	if($importe > 0){
	$ins.="($ida,$id_tiend,'$importe'),";	
		}
	}
}		

}}


$ins=substr($ins, 0,-1);

if($ins){
$queryp="INSERT INTO fij_pvp (id_articulo,id_tienda,pvp) VALUES $ins;";	
$dbnivel->query($queryp);if($debug){echo $queryp . "\n";};
}

foreach ($hay as $idti => $idbd2) { foreach ($idbd2 as $ida => $idbd) {
	

$npvp=$fijos[$ida][$idti];	
$queryp="UPDATE fij_pvp set pvp=$npvp WHERE id=$idbd;";	
$dbnivel->query($queryp);if($debug){echo $queryp . "\n";};

}
}

$queryp="DELETE FROM fij_pvp WHERE pvp=0;";	
$dbnivel->query($queryp);if($debug){echo $queryp . "\n";};

if (!$dbnivel->close()){die($dbnivel->error());};	

}

	



?>