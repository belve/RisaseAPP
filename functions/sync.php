<?php

function SyncModBD_T($sync_sql,$tiends){global $dbnivel; global $tiendas;

$tie=explode(' ',$tiends);


$sync_sql=addslashes($sync_sql);


$sql="INSERT INTO syncupdate (id_tiend, syncSql) VALUES ";

foreach ($tie as $point => $idt) {
$nomt=$tiendas[$idt];	
	
$sql .="($idt, '$sync_sql'), ";
}

$sql=substr($sql, 0, strlen($sql)-2);
$sql .=";";

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= $sql; #echo $queryp;
$dbnivel->query($queryp);

if (!$dbnivel->close()){die($dbnivel->error());};


}


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





function SyncModBDARRAY($sync_sqlA){global $dbnivel; global $tiendas;


$sql="INSERT INTO syncupdate (id_tiend, syncSql) VALUES ";


foreach ($sync_sqlA as $key => $sync_sql) {
$sync_sql=addslashes($sync_sql);
foreach ($tiendas as $idt => $nomt) {
$sql .="($idt, '$sync_sql'), ";
}		
}


$sql=substr($sql, 0, strlen($sql)-2);
$sql .=";";

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= $sql; #echo $queryp;
$dbnivel->query($queryp);

if (!$dbnivel->close()){die($dbnivel->error());};


}





function SyncModBDbytien($sync_sql,$idt){global $dbnivel; global $tiendas;

$sync_sql=addslashes($sync_sql);


$sql="INSERT INTO syncupdate (id_tiend, syncSql) VALUES ('$idt', '$sync_sql');";



if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= $sql; #echo $queryp;
$dbnivel->query($queryp);

if (!$dbnivel->close()){die($dbnivel->error());};


}



?>