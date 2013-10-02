<?php
set_time_limit(0);
require_once("../db.php");$rows=array();
$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};

$idt='';
$queryp= "select max(idt) as midt from ticket_det;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$idt=$row['midt'];};
if(!$idt){$idt="0";};

$cnoms="";
$queryp= "select id, id_ticket from tickets WHERE id > $idt LIMIT 10;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
	$cnoms.="'" . $row['id_ticket'] . "',";
	$idsti[$row['id_ticket']]=$row['id'];
};
$cnoms=substr($cnoms, 0,-1);

if (!$dbnivel->close()){die($dbnivel->error());};





include('../adodb5/adodb.inc.php'); $driv="odbc_mssql";
$db =& ADONewConnection($driv);
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risase;";
$db->Connect($dsn,'remoto','azul88');
$db->debug = false;
$sql="SELECT det_idTicket, det_idarticulo, det_cantidad, det_precio FROM DetalleTicket where det_idTicket IN ($cnoms);";
$rs = $db->Execute($sql);


$rows = $rs->GetRows();



$vals="";
if(count($rows)>0){
foreach ($rows as $key => $row) {

$detalles[$row[0]][idt]=$idsti[$row[0]];	
$detalles[$row[0]][ida]=$row[1];
$detalles[$row[0]][can]=$row[2];
$detalles[$row[0]][pre]=$row[3];	
}}

print_r($detalles);

?>