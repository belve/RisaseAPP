<?php
session_start();
set_time_limit(0);
ini_set("memory_limit", "-1");


require_once("../db.php");
require_once("../variables.php");

$user=""; $pass=""; $id=""; $igeneral=0; $util=0; $risasa=0;

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};


if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id, util, igeneral, risasa from users where user='$user' AND pass='$pass';"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$id=$row['id']; $igeneral=$row['igeneral']; $util=$row['util']; $risasa=$row['risasa']; };

if($id){
$_SESSION['ussid']['id']=$id;
$_SESSION['ussid']['ig']=$igeneral;
$_SESSION['ussid']['ut']=$util;
$_SESSION['ussid']['ra']=$risasa;
$res['ok']=1;		
}else{
$res['no']=1;	
}

if (!$dbnivel->close()){die($dbnivel->error());};







echo json_encode($res);
?>