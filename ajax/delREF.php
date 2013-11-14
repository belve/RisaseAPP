<?php
require_once("../db.php");
require_once("../variables.php");
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$list=substr($list, 0,-1);

if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "DELETE FROM repartir WHERE id_articulo IN ($list);";
$dbnivel->query($queryp); echo $dbnivel->error();

$queryp= "DELETE FROM fij_pvp WHERE id_articulo IN ($list);";
$dbnivel->query($queryp); echo $dbnivel->error();

$queryp= "DELETE FROM fij_stock WHERE id_articulo IN ($list);";
$dbnivel->query($queryp); echo $dbnivel->error();

$queryp= "DELETE FROM articulos WHERE id IN ($list);";
$dbnivel->query($queryp); echo $dbnivel->error();
if (!$dbnivel->close()){die($dbnivel->error());};

SyncModBD($queryp);

$queryp= "DELETE FROM pvp_fijo WHERE id_articulo IN ($list);";
SyncModBD($queryp);

$queryp= "DELETE FROM stocklocal WHERE id_art IN ($list);";
SyncModBD($queryp);







$dbnivelBAK=new DB('192.168.1.11','tpv','tpv','tpv_backup');
if (!$dbnivelBAK->open()){die($dbnivelBAK->error());};

foreach ($tiendas as $idt => $value) {
$queryp= "DELETE FROM stocklocal_$idt WHERE id_art IN ($list);";
$dbnivelBAK->query($queryp);	
}

if (!$dbnivelBAK->close()){die($dbnivelBAK->error());};

$vals['ok']=1;
echo json_encode($vals);


?>