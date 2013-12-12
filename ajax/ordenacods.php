<?php
session_start();

$debug=0;
$codis="";	$codigos=array();

//print_r($_POST);

if(!array_key_exists('codis', $_SESSION)){ $_SESSION['codis']="";};

if(array_key_exists('doit', $_POST)){$doit=$_POST['doit'];}else{$doit=0;};

if($doit==1){$codis=""; $_SESSION['codis']=$codis;};
if($doit==0){$codis=$_SESSION['codis']; $codis.=' ' . $_POST['codis']; $_SESSION['codis']=$codis;};

if($doit==2){$codis=$_SESSION['codis'];

require_once("../db.php");
require_once("../variables.php");

if(trim($codis)){
trim($codis);	
	
$ids=str_replace(' ', ',',trim($codis));
$ids=str_replace(',,,', ',',$ids);
$ids=str_replace(',,', ',',$ids);	

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select id, codbarras from articulos where id in ($ids);";
$dbnivel->query($queryp);if($debug){echo $queryp . "\n\n";};echo $dbnivel->error();
while ($row = $dbnivel->fetchassoc()){
$id=$row['id'];
$codb=$row['codbarras'];
$g=substr($codb, 0,1);
$s=substr($codb, 1,1);
$cod=substr($codb, 4);


$codigos[$g][$s][$cod]=$id;

}


if($debug){print_r($codigos); echo "\n";};

ksort($codigos);
$newlist="";
foreach ($codigos as $g => $sub) {
	ksort($sub);
	foreach ($sub as $s => $cods){
	ksort($cods);	
	foreach ($cods as $c => $id){
			
$newlist .=$id . " ";	

	}}}

if (!$dbnivel->close()){die($dbnivel->error());};

//$val[1]=$newlist;
echo trim($newlist);
}else{
//$val[1]=$codis;
echo trim($codis);	
}


}

//echo json_encode($val);
?>