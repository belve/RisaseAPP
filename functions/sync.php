<?php

function SyncModBD($sync_sql){global $dbnivel; global $tiendas;

$sync_sql=addslashes($sync_sql);


$sql="INSERT INTO syncupdate (id_tiend, syncSql) VALUES ";

foreach ($tiendas as $idt => $nomt) {
$sql .="($idt, '$sync_sql'), ";
}

$sql=substr($sql, 0, strlen($sql)-2);
$sql .=";";

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= $sql; #echo $queryp;
$dbnivel->query($queryp);

if (!$dbnivel->close()){die($dbnivel->error());};


}


?>