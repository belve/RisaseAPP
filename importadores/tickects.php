<?php 
$ini=2013;
set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};




include('../adodb5/adodb.inc.php'); $driv="odbc_mssql";
$db =& ADONewConnection($driv);
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risase;";
$db->Connect($dsn,'remoto','azul88');
$db->debug = false;
$sql="SELECT tic_idticket, tic_idEmpleado, tic_fecha, tic_importe FROM Tickets where tic_fecha = '10/01/2008';";
$rs = $db->Execute($sql);


$rows = $rs->GetRows();


foreach ($rows as $key => $row) {
	
$valores[$row[0]]['ie']=$row[1];
$valores[$row[0]]['dt']=$row[2];
$valores[$row[0]]['im']=$row[3];

}

$db->Close();


print_r($valores);


?>