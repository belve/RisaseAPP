<?php 
$ini=2013;
set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};




include('../adodb5/adodb.inc.php'); $driv="odbc_mssql";
$db =& ADONewConnection($driv);
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risase;";
$db->Connect($dsn,'remoto','azul88');
$db->debug = false;
$sql="SELECT count(tic_id_tickket) FROM Tickets;";

$rs = $db->Execute($sql);


$rows = $rs->GetRows();
print_r($rows);

//foreach ($rows as $key => $row) {foreach($camp as $nkey => $nomcampo){
	
//$valores[$count][$nkey]=trim(utf8_encode($row[$nkey]));

//}}

$db->Close();



?>