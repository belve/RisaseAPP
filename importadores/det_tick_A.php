<?php
set_time_limit(0);
require_once("../db.php");$rows=array();
$dbnivel=new DB('192.168.1.11','edu','admin','risasa');
if (!$dbnivel->open()){die($dbnivel->error());};

$idt='';
$queryp= "select max(idt) as midt from ticket_det;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$idt=$row['midt'];};
if(!$idt){$idt="0";};
 echo $queryp;
echo "<br><br>";

$queryp= "select id_ticket from ticket_det where idt='$idt';";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$idtt=$row['id_ticket'];};

 echo $queryp;
echo "<br><br>";

$queryp= "select id from tickets where id_ticket='$idtt';";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$idttt=$row['id'];};
 echo $queryp;
echo "<br><br>";

$cnoms="";
$queryp= "select id, id_ticket, id_tienda, fecha, hora from tickets WHERE id > $idttt LIMIT 5000;";
$dbnivel->query($queryp); echo $queryp; 
while ($row = $dbnivel->fetchassoc()){
	$cnoms.="'" . $row['id_ticket'] . "',";
	$idsti[$row['id_ticket']]=$row['id'];
	$ids_ti[$row['id']]=$row['id_tienda'];
	$ids_fech[$row['id']]=$row['fecha'];
	$ids_hora[$row['id']]=$row['hora'];
};
$cnoms=substr($cnoms, 0,-1);

if (!$dbnivel->close()){die($dbnivel->error());};





include('../adodb5/adodb.inc.php'); $driv="odbc_mssql";
$db =& ADONewConnection($driv);
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risasa;";
$db->Connect($dsn,'remoto','azul88');
$db->debug = false;
$sql="SELECT det_idTicket, det_idarticulo, det_cantidad, det_precio FROM DetalleTicket where det_idTicket IN ($cnoms);";
$rs = $db->Execute($sql);


$rows = $rs->GetRows();

$db->Close();

$vals="";$idsbusco=array();
if(count($rows)>0){
foreach ($rows as $key => $row) {

$tt=trim($row[0]);
$detalles[$tt][$row[1]]['idt']=$idsti[$tt];	
$detalles[$tt][$row[1]]['can']=$row[2];
$detalles[$tt][$row[1]]['pre']=$row[3];

if(!array_key_exists($row[1],$idsbusco)){$idsbusco[$row[1]]=1;};
	
}}

$idas="";
foreach ($idsbusco as $idb => $poin) {
$idas.="$idb,";	
}
$idas=substr($idas, 0,-1);



$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select id, codbarras from articulos where id IN ($idas);";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$cdbars[$row['id']]=$row['codbarras'];};
if (!$dbnivel->close()){die($dbnivel->error());};




$insV="";
foreach ($detalles as $tnom => $arts) {foreach ($arts as $ida => $values){
$idti=$values['idt'];
$id_ti=$ids_ti[$idti];		
$codbar=$cdbars[$ida]; $g=substr($codbar,0,1);$sg=substr($codbar,1,1);
$can=$values['can'];
$pre=$values['pre'];$pre=(str_replace('-','',$pre))*1;

$fecha=$ids_fech[$idti];	
$hora=$ids_hora[$idti];	


$insV .="('$idti','$id_ti','$tnom','$codbar',$g,$sg,'$can','$pre','$fecha','$hora'),";	
}}
$insV=substr($insV, 0,-1);


$dbnivel=new DB('192.168.1.11','edu','admin','risasa');
if (!$dbnivel->open()){die($dbnivel->error());};
$queryp="INSERT INTO ticket_det (idt,id_tienda,id_ticket,id_articulo,g,sg,cantidad,importe,fecha,hora) VALUES $insV;";
$dbnivel->query($queryp);echo $queryp;

if (!$dbnivel->close()){die($dbnivel->error());};

?>


<script>
 window.location.href = "/importadores/det_tick_A.php";
</script>