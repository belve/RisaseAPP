<?php 

require_once("../db.php");
$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};

$count=0;;
$queryp= "select id, id_tienda from tiendas;";

$listado="";

$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$count++;
	
	$idttt=$row['id'];$nidtienda=$row['id_tienda'];
	$tiendas[$nidtienda]=$idttt;
	
};

if (!$dbnivel->close()){die($dbnivel->error());};


$ini=2013;
set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};




include('../adodb5/adodb.inc.php'); $driv="odbc_mssql";
$db =& ADONewConnection($driv);
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risase;";
$db->Connect($dsn,'remoto','azul88');
$db->debug = false;
$sql="SELECT TOP 10 tic_idticket, tic_idEmpleado, tic_fecha, tic_importe FROM Tickets where tic_fecha = '10/01/2008';";
$rs = $db->Execute($sql);


$rows = $rs->GetRows();

$vals="";
foreach ($rows as $key => $row) {

$t=$row[0];
$idem=$row[1];
$date=$row[2];
$imp=$row[3];

if(is_numeric(substr($t,3,1))){$codt=substr($t, 0,3);}else{$codt=substr($t, 0,4);};
$idt=$tiendas[$codt];

$vals .="($idt,$t,$idem,'$date','$imp')";

}

$db->Close();



$vals=substr($vals, 0,-1);

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp ="INSERT INTO tickets (id_tienda,id_ticket,id_empleado,fecha,importe) VALUES $vals;";
$dbnivel->query($queryp);echo $queryp;
if (!$dbnivel->close()){die($dbnivel->error());};



?>