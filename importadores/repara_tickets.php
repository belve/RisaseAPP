<?php




require_once("../db.php");$rows=array();
$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};



$lids="";
$ltiks="";	
$queryp= "select id, count(id) as C , id_ticket, fecha from tickets 
where  fecha > '2013-10-01'  group by id_ticket ORDER BY C DESC, fecha;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$c=$row['C'];	

if($c>1){	
$id=$row['id']; $idti=$row['id_ticket'];
$ticks[$idti]=$id;

$lids.=$id . ",";
$ltiks.="'$idti'" . ",";			
}

}


$lids=substr($lids, 0,-1);
$ltiks=substr($ltiks, 0,-1);



if (!$dbnivel->close()){die($dbnivel->error());};

print_r($lids);
