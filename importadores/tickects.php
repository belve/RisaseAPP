<?php 

function add_days($date, $days) {
    $timeStamp = strtotime(date('Y-m-d',$date));
    $timeStamp+= 24 * 60 * 60 * $days;

    // ...clock change....
    if (date("I",$timeStamp) != date("I",$date)) {
        if (date("I",$date)=="1") { 
            // summer to winter, add an hour
            $timeStamp+= 60 * 60; 
        } else {
            // summer to winter, deduct an hour
            $timeStamp-= 60 * 60;           
        } // if
    } // if
    $cur_dat = mktime(0, 0, 0, 
                      date("n", $timeStamp), 
                      date("j", $timeStamp), 
                      date("Y", $timeStamp)
                     ); 
    return $cur_dat;
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


echo "$date \n";
$date=add_days($date, 1);
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

