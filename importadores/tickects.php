<?php 

function add_days($Date1, $days) {
 

$date = new DateTime($Date1);
$date->add(new DateInterval('P1D')); // P1D means a period of 1 day
$Date2 = $date->format('Y-m-d');

    return $Date2;
}






require_once("../db.php");$rows=array();
$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id, id_tienda from tiendas;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){	
	$idttt=$row['id'];$nidtienda=$row['id_tienda'];
	$tiendas[$nidtienda]=$idttt;
}



$queryp= "select max(fecha) as date from tickets;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$date=$row['date'];};

$date=substr($date,0,4) . "-" . substr($date,5,2) . "-" . substr($date,8,2);
echo "$date \n";
$date=add_days($date, 1);
$date=substr($date,0,4) . "-" . substr($date,5,2) . "-" . substr($date,8,2);
echo "$date \n";




if (!$dbnivel->close()){die($dbnivel->error());};


set_time_limit(0);




include('../adodb5/adodb.inc.php'); $driv="odbc_mssql";
$db =& ADONewConnection($driv);
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risase;";
$db->Connect($dsn,'remoto','azul88');
$db->debug = false;
$sql="SELECT TOP 1 tic_idticket, tic_idEmpleado, tic_fecha, tic_importe FROM Tickets where tic_fecha = '$date';";
$rs = $db->Execute($sql);


$rows = $rs->GetRows();

$vals="";
if(count($rows)>0){
foreach ($rows as $key => $row) {

$t=trim($row[0]);
$idem=$row[1];
$date=$row[2];
$imp=$row[3];

if(is_numeric(substr($t,3,1))){$codt=substr($t, 0,3);}else{$codt=substr($t, 0,4);};
$idt=$tiendas[$codt];

$vals .="($idt,'$t',$idem,'$date','$imp'),";

}}else{
$vals .="(0,'-',0,'$date','0'),";	
}

$db->Close();

if(!$vals){$vals .="(0,'-',0,'$date','0'),";};

$vals=substr($vals, 0,-1);

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp ="INSERT INTO tickets (id_tienda,id_ticket,id_empleado,fecha,importe) VALUES $vals;";
$dbnivel->query($queryp);echo $queryp;
if (!$dbnivel->close()){die($dbnivel->error());};



?>



<script>
	 window.location.href = "/importadores/tickects.php";
</script>

