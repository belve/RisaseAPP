<?php 
$ultREP=5000;
set_time_limit(0);




require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select max(id) as max from agrupedidos where tip=1;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$ultREP=$row['max'];};


foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$ultREP=$ultREP*1;



$queryp= "select id,id_tienda from tiendas";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$T[$row['id_tienda']]=$row['id'];};

$queryp= "select id, nombre, estado, fecha from agrupedidos where id > $ultREP AND tip=2 ORDER BY id limit 30;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	
			
	if(array_key_exists(substr($row['nombre'],0,4), $T)){
	$tiend=	substr($row['nombre'],0,4);	
	}else{
	$tiend=	substr($row['nombre'],0,3);	
	}
		
		
	$cuales[$row['id']]['n']=$row['nombre'];
	$cuales[$row['id']]['e']=$row['estado'];
	$cuales[$row['id']]['t']=$tiend;
	
	$fechas[$row['id']]=$row['fecha'];
};






print_r($cuales);
echo "<br> $ultREP";




##### datos OLD
$Ntab='DetallePedido';




$camp[1]='det_idArticulo';
$camp[2]='det_PrecioVenta';
$camp[3]='det_Unidades';




##### datos NEW
$nNtab="repartir";
$nNid='id';


$ncamp[1]='id_articulo';
$ncamp[2]='pventa';
$ncamp[3]='cantidad';
$ncamp[4]='id_tienda';
$ncamp[5]='estado';






include('../adodb5/adodb.inc.php'); $driv="odbc_mssql";
$db =& ADONewConnection($driv);
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risase;";
$db->Connect($dsn,'remoto','azul88');
$db->debug = false;

foreach($cuales as $id => $vales){
$nomr=$vales['n'];
$sql="SELECT * FROM $Ntab where det_idPedido='$nomr';";
$rs = $db->Execute($sql);


$rows = $rs->GetRows();$count=1;
#print_r($rows);

foreach ($rows as $key => $row) {
	$count++;
	$valores[$id][$count][4]=$T[$vales['t']];
	$valores[$id][$count][5]=$vales['e'];
		foreach($camp as $nkey => $nomcampo){
		$valores[$id][$count][$nkey]=trim(utf8_encode($row[$nkey]));

	}}
}


$db->Close();


#print_r($valores);

$valopi="";$valopi2="";

foreach ($valores as $val1 => $val2a) {foreach($val2a as $cuenta => $val2){

$sqlcamps="";$sqlvals="";
foreach ($val2 as $nnkey => $valuecamp)	{
	
		
	$sqlcamps .= "$ncamp[$nnkey],";
	$sqlvals .= "'$valuecamp',";
}
	
$sqlcamps=substr($sqlcamps, 0,strlen($sqlcamps)-1);	
$sqlvals=substr($sqlvals, 0,strlen($sqlvals)-1);	
$fecha=$fechas[$val1];
$valopi2 .="($val1,'2',$sqlvals,'$fecha'),";
}}



$valopi=substr($valopi, 0,strlen($valopi)-1);
$valopi2=substr($valopi2, 0,strlen($valopi2)-1);


$queryp= "INSERT INTO pedidos (agrupar,tip,$sqlcamps,fecha) values $valopi2;";

echo $queryp;

$dbnivel->query($queryp);




if (!$dbnivel->close()){die($dbnivel->error());};

$ultREP++;
$ultREP=$ultREP + 9;
?>


<script>
	window.location.href = "/importadores/detpedido.php?ultREP=<?php echo $ultREP; ?>"; 
</script>


