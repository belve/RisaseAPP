<?php 
$ultREP=0;
set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$ultREP=$ultREP*1;



require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id,id_tienda from tiendas";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$T[$row['id_tienda']]=$row['id'];};

$queryp= "select id, nombre from agrupedidos where id > $ultREP AND tip=1 ORDER BY id limit 5;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$cuales[$row['id']]=$row['nombre'];};






print_r($cuales);
echo "<br> $ultREP";




##### datos OLD
$Ntab='DetalleReparto';




$camp[1]='det_idarticulo';
$camp[2]='det_idtienda';
$camp[3]='det_cantidad';

$camp[5]='det_stockmin';
$camp[6]='det_estado';


$camp2[1]='det_idarticulo';
$camp2[2]='det_idtienda';
$camp2[3]='det_cantidad';
$camp2[6]='det_estado';



##### datos NEW
$nNtab="repartir";

$nNid='id';



$ncamp[1]='id_articulo';
$ncamp[2]='id_tienda';
$ncamp[3]='cantidad';

$ncamp[5]='stockmin';
$ncamp[6]='estado';





include('../adodb5/adodb.inc.php'); $driv="odbc_mssql";
$db =& ADONewConnection($driv);
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risase;";
$db->Connect($dsn,'remoto','azul88');
$db->debug = false;

foreach($cuales as $id => $nomr){
$sql="SELECT * FROM $Ntab where det_idreparto='$nomr';";
$rs = $db->Execute($sql);


$rows = $rs->GetRows();$count=1;
#print_r($rows);

foreach ($rows as $key => $row) {$count++;foreach($camp as $nkey => $nomcampo){

$valores[$id][$count][$nkey]=trim(utf8_encode($row[$nkey]));
}}
}


$db->Close();

#print_r($valores);



$valopi="";$valopi2="";

foreach ($valores as $val1 => $val2a) {foreach($val2a as $cuenta => $val2){

$sqlcamps="";$sqlvals="";
foreach ($val2 as $nnkey => $valuecamp)	{
	
if($nnkey==1){$a_idart=$valuecamp;};
if($nnkey==2){$valuecamp=$T[$valuecamp];$a_idtt=$valuecamp;};
if($nnkey==3){$a_cant=$valuecamp;};
if($nnkey==6){$a_est=$valuecamp;};




		
	$sqlcamps .= "$ncamp[$nnkey],";
	$sqlvals .= "'$valuecamp',";
}
	
$sqlcamps=substr($sqlcamps, 0,strlen($sqlcamps)-1);	
$sqlvals=substr($sqlvals, 0,strlen($sqlvals)-1);	

$valopi .="($sqlvals),";


$valopi2 .="($val1,'1','$a_idart','$a_idtt','$a_cant','$a_est'),";
}}



$valopi=substr($valopi, 0,strlen($valopi)-1);
$valopi2=substr($valopi2, 0,strlen($valopi2)-1);

$queryp= "INSERT INTO $nNtab ($sqlcamps) values $valopi;";
$dbnivel->query($queryp);

$queryp= "INSERT INTO pedidos (agrupar,tip,id_articulo,id_tienda,cantidad,estado) values $valopi2;";
$dbnivel->query($queryp);



if (!$dbnivel->close()){die($dbnivel->error());};

$ultREP++;
$ultREP=$ultREP + 4;
?>


<script>
//	window.location.href = "/importadores/detreparto.php?ultREP=<?php echo $ultREP; ?>"; 
</script>


