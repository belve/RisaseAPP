<?php 
$ultREP=0;
set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};





require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id,id_tienda from tiendas";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$T[$row['id_tienda']]=$row['id'];};

$queryp= "select max(id_reparto) as ultimo from detreparto;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$ultREP=$row['ultimo'];};

$queryp= "select id, nomrep from repartos where id > $ultREP limit 50;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$cuales[$row['id']]=$row['nomrep'];};



if (!$dbnivel->close()){die($dbnivel->error());};


print_r($T);
echo "<br> $ultREP";




##### datos OLD
$Ntab='DetalleReparto';




$camp[2]='det_idarticulo';
$camp[3]='det_idtienda';
$camp[4]='det_cantidad';
$camp[5]='det_recibida';
$camp[6]='det_stockmin';
$camp[7]='det_estado';



##### datos NEW
$nNtab="detreparto";

$nNid='id';



$ncamp[2]='id_articulo';
$ncamp[3]='id_tienda';
$ncamp[4]='cantidad';
$ncamp[5]='recibida';
$ncamp[6]='stockmin';
$ncamp[7]='estado';



$conn=odbc_connect('risase','edu','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}

foreach($cuales as $id => $nomr){

$sql="SELECT * FROM $Ntab where det_idreparto=$nomr;";


$rs=odbc_exec($conn,$sql);
if (!$rs)
 {exit("Error in SQL");}



while (odbc_fetch_row($rs))
{
foreach($camp as $nkey => $nomcampo){
$valores[$id][$nkey]=trim(utf8_encode(odbc_result($rs,$nomcampo)));
}}

}

odbc_close($conn);




$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};



foreach ($valores as $val1 => $val2) {


$sqlcamps="";$sqlvals="";
foreach ($val2 as $nnkey => $valuecamp)	{

if($nnkey==3){$valuecamp=$T[$valuecamp];};
		
	$sqlcamps .= "$ncamp[$nnkey],";
	$sqlvals .= "'$valuecamp',";
}
	
$sqlcamps=substr($sqlcamps, 0,strlen($sqlcamps)-1);	
$sqlvals=substr($sqlvals, 0,strlen($sqlvals)-1);	
	
$queryp= "INSERT INTO $nNtab (id_reparto,$sqlcamps) values ($val1,$sqlvals);";
$dbnivel->query($queryp);
#echo $queryp . "\n";
}

if (!$dbnivel->close()){die($dbnivel->error());};


?>

<!--
<script>
	 window.location.href = "/importadores/repartos.php?ini=<?php echo $ini;?>";
</script>
-->

