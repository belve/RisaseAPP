<?php
session_start();
$debug=0;

#print_r($_GET);

#foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

if(array_key_exists('arts', $_GET)){$artis=$_GET['arts'];};
$id_rebaja=$_GET['id_rebaja'];
$fini=$_GET['fini'];
$ffin=$_GET['ffin'];
$tisel=$_GET['tisel'];


if(array_key_exists('doit', $_GET)){$doit=$_GET['doit'];}else{$doit=0;}

if($doit==1){$arts=array();};
if($doit==0){$arts=$_SESSION['arts']; foreach ($artis as $idart => $precio) {$arts[$idart]=$precio;}; $_SESSION['arts']=$arts; }


if($doit==2){
$arts=$_SESSION['arts'];

$queryp2="";$queryp1="";	
require_once("../db.php");
require_once("../variables.php");
if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select tiendas from rebajas where id=$id_rebaja;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$tisel2=$row['tiendas'];};
$queryp= "UPDATE rebajas set tiendas='$tisel' where id=$id_rebaja;";
$dbnivel->query($queryp);if($debug){echo $queryp . "\n";};
$queryp1= "DELETE FROM det_rebaja where id_rebaja=$id_rebaja;";
$dbnivel->query($queryp1);if($debug){echo $queryp . "\n";};

if(count($arts)>0){	
$artics="";
foreach ($arts as $idart => $precio) {$artics .="($id_rebaja,$idart,$precio,'$fini','$ffin'),";};	
$artics=substr($artics, 0, strlen($artics)-1);
$queryp2= "INSERT INTO det_rebaja (id_rebaja,id_articulo,precio,fecha_ini,fecha_fin) VALUES $artics;";
$dbnivel->query($queryp2); if($debug){echo $queryp . "\n";};
}
	

	
if (!$dbnivel->close()){die($dbnivel->error());};	
if($queryp1){SyncModBD_T($queryp1,$tisel2);};	
if($queryp2){SyncModBD_T($queryp2,$tisel);};
}

$vals['ok']=$id_rebaja;	
echo json_encode($vals);

	
?>	