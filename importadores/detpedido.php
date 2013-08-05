<?php 
$ultREP=6229;
set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$ultREP=$ultREP*1;



require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id,id_tienda from tiendas";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$T[$row['id_tienda']]=$row['id'];};

$queryp= "select id, nombre, estado from agrupedidos where id > $ultREP AND tip=2 ORDER BY id limit 5;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	
	$check=substr($row['nombre'],3,1);
	if(is_numeric($check*1)){
	$tiend=	substr($row['nombre'],0,3);
	}else{
	$tiend=	substr($row['nombre'],0,4);	
	}
		
	$cuales[$row['id']]['n']=$row['nombre'];
	$cuales[$row['id']]['e']=$row['estado'];
	$cuales[$row['id']]['t']=$tiend;
};






print_r($cuales);
echo "<br> $ultREP";




##### datos OLD
$Ntab='DetallePedido';




$camp[5]='det_idArticulo';
$camp[6]='det_Unidades';




##### datos NEW
$nNtab="repartir";

$nNid='id';


$ncamp[1]='id_tienda';
$ncamp[2]='estado';
$ncamp[5]='id_articulo';
$ncamp[6]='cantidad';







$conn=odbc_connect('risase','edu','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}

$count=0;
foreach($cuales as $id => $vales){

$nomr=$vales['n'];

$sql="SELECT * FROM $Ntab where det_idPeparto='$nomr';";


$rs=odbc_exec($conn,$sql);
if (!$rs)
 {exit("Error in SQL");}



while (odbc_fetch_row($rs))
{$count++;

$valores[$id][$count][1]=$T[$vales['t']];
$valores[$id][$count][2]=$vales['e'];
foreach($camp as $nkey => $nomcampo){
$valores[$id][$count][$nkey]=trim(utf8_encode(odbc_result($rs,$nomcampo)));
}}

}

odbc_close($conn);







$valopi="";$valopi2="";

foreach ($valores as $val1 => $val2a) {foreach($val2a as $cuenta => $val2){

$sqlcamps="";$sqlvals="";
foreach ($val2 as $nnkey => $valuecamp)	{
	
		
	$sqlcamps .= "$ncamp[$nnkey],";
	$sqlvals .= "'$valuecamp',";
}
	
$sqlcamps=substr($sqlcamps, 0,strlen($sqlcamps)-1);	
$sqlvals=substr($sqlvals, 0,strlen($sqlvals)-1);	

$valopi2 .="($val1,'2',$sqlvals),";
}}



$valopi=substr($valopi, 0,strlen($valopi)-1);
$valopi2=substr($valopi2, 0,strlen($valopi2)-1);


$queryp= "INSERT INTO pedidos (agrupar,tip,$sqlcamps) values $valopi2;";

echo $queryp;

#$dbnivel->query($queryp);




if (!$dbnivel->close()){die($dbnivel->error());};

$ultREP++;
$ultREP=$ultREP + 4;
?>


<script>
	window.location.href = "/importadores/detpedido.php?ultREP=<?php echo $ultREP; ?>"; 
</script>


