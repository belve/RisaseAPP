<?php
require_once("../db.php");
require_once("../variables.php");

$hoy=date('Y') . "-" . date('m') . "-" . date('d');

echo $hoy . "\n";


if (!$dbnivel->open()){die($dbnivel->error());};

$queryp="DELETE FROM rebajas WHERE ffin < '$hoy';";
$dbnivel->query($queryp); echo $dbnivel->error();

if (!$dbnivel->close()){die($dbnivel->error());};

$queryp="DELETE FROM det_rebaja WHERE fecha_fin < '$hoy';";
SyncModBD($queryp);


?>