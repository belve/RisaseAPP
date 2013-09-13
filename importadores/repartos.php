<?php 
$ini=2003;
set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};


##### datos OLD
$Ntab='Repartos';

$Nid='art_idArticulo';

$camp[1]='rep_NumeroRep';
$camp[2]='rep_fecha';
$camp[3]='rep_estado';




##### datos NEW
$nNtab="agrupedidos";

$nNid='id';


$ncamp[1]='nombre';
$ncamp[2]='fecha';
$ncamp[3]='estado';





include('../adodb5/adodb.inc.php'); $driv="odbc_mssql";
$db =& ADONewConnection($driv);
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risase;";
$db->Connect($dsn,'remoto','azul88');
$db->debug = false;
$sql="SELECT * FROM $Ntab where rep_fecha <= '31/12/$ini' AND rep_fecha >= '01/01/$ini';";
$rs = $db->Execute($sql);


$rows = $rs->GetRows();$count=1;
print_r($rows);

foreach ($rows as $key => $row) {$count++;foreach($camp as $nkey => $nomcampo){
	
	#$valores[$count][$nkey]=trim(utf8_encode($row[$nkey]));

}}

$db->Close();




print_r($valores);



require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};


$valopi="";
foreach ($valores as $val1 => $val2) {


$sqlcamps="";$sqlvals="";
foreach ($val2 as $nnkey => $valuecamp)	{
	
	$sqlcamps .= "$ncamp[$nnkey],";
	$sqlvals .= "'$valuecamp',";
}
	
$sqlcamps=substr($sqlcamps, 0,strlen($sqlcamps)-1);	
$sqlvals=substr($sqlvals, 0,strlen($sqlvals)-1);	
$valopi .="($sqlvals,1),";	

}

$valopi=substr($valopi, 0,strlen($valopi)-1);	

$queryp= "INSERT INTO $nNtab ($sqlcamps,tip) values $valopi;";
if($ini <= 2011){$dbnivel->query($queryp);};
#echo $queryp . "\n";



if (!$dbnivel->close()){die($dbnivel->error());};

$ini++;
?>

<script>
	 //window.location.href = "/importadores/repartos.php?ini=<?php echo $ini;?>";
</script>


