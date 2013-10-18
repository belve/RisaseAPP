<?php 

function add_days($Date1, $days) {
 

$date = new DateTime($Date1);
$date->add(new DateInterval('P1D')); // P1D means a period of 1 day
$Date2 = $date->format('Y-m-d');

    return $Date2;
}






require_once("../db.php");$rows=array();
$dbnivel=new DB('192.168.1.11','edu','admin','risasa');
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
$date2= substr($date,8,2) . "/"  .  substr($date,5,2) . "/" . substr($date,0,4);
echo "$date \n";




if (!$dbnivel->close()){die($dbnivel->error());};


set_time_limit(0);




include('../adodb5/adodb.inc.php'); $driv="odbc_mssql";
$db =& ADONewConnection($driv);
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risasa;";
$db->Connect($dsn,'remoto','azul88');
$db->debug = false;
$sql="SELECT tic_idticket, tic_idEmpleado, tic_fecha, tic_importe FROM Tickets where tic_fecha = '$date2';";
$rs = $db->Execute($sql); echo "\n" . $sql;


$rows = $rs->GetRows();



$vals="";
if(count($rows)>0){
foreach ($rows as $key => $row) {

$t=trim($row[0]);
$idem=$row[1];
$date=$row[2];
$date=substr($date,0,4) . "-" . substr($date,5,2)  . "-" . substr($date,8,2);
$imp=$row[3];



if(strlen($t)==14){$tpt=3;};
if(strlen($t)==15){$tpt=3; if(!is_numeric(substr($t,3,1))){$tpt=3;};  };
if(strlen($t)==16){$tpt=4;};

$codt=substr($t, 0,$tpt);

$num=str_replace($codt, '', $t);
$hora=substr($num,6,2);
$hora=$hora*1;


$idt=$tiendas[$codt];

$vals .="($idt,'$t',$idem,'$date',$hora,'$imp'),";

}}else{
$vals .="(0,'-',0,'$date',0,'0'),";	
}

$db->Close();

if(!$vals){$vals .="(0,'-',0,'$date',0,'0'),";};

$vals=substr($vals, 0,-1);

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp ="INSERT INTO tickets (id_tienda,id_ticket,id_empleado,fecha,hora,importe) VALUES $vals;";
$dbnivel->query($queryp);echo $queryp;
if (!$dbnivel->close()){die($dbnivel->error());};



?>



<script>
 window.location.href = "/importadores/tickects.php";
</script>

