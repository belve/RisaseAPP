<?php 
$ultREP=700;
set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};





require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id,id_tienda from tiendas";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$T[$row['id_tienda']]=$row['id'];};

$queryp= "select id, nombre from agrupedidos where id > $ultREP ORDER BY id limit 1;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$cuales[$row['id']]=$row['nombre'];};






print_r($cuales);
echo "<br> $ultREP";




##### datos OLD
$Ntab='DetalleReparto';




$camp[2]='det_idarticulo';
$camp[3]='det_idtienda';
$camp[4]='det_cantidad';

$camp[6]='det_stockmin';
$camp[7]='det_estado';


$camp2[2]='det_idarticulo';
$camp2[3]='det_idtienda';
$camp2[4]='det_cantidad';
$camp2[7]='det_estado';



##### datos NEW
$nNtab="repartir";

$nNid='id';



$ncamp[2]='id_articulo';
$ncamp[3]='id_tienda';
$ncamp[4]='cantidad';

$ncamp[6]='stockmin';
$ncamp[7]='estado';





$conn=odbc_connect('risase','edu','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}

$count=0;
foreach($cuales as $id => $nomr){

$sql="SELECT * FROM $Ntab where det_idreparto='$nomr';";


$rs=odbc_exec($conn,$sql);
if (!$rs)
 {exit("Error in SQL");}



while (odbc_fetch_row($rs))
{$count++;
foreach($camp as $nkey => $nomcampo){
$valores[$id][$count][$nkey]=trim(utf8_encode(odbc_result($rs,$nomcampo)));
}}

}

odbc_close($conn);







$valopi="";$valopi2="";

foreach ($valores as $val1 => $val2a) {foreach($val2a as $cuenta => $val2){

$sqlcamps="";$sqlvals="";
foreach ($val2 as $nnkey => $valuecamp)	{
	
if($nnkey==2){$a_idart=$valuecamp;};
if($nnkey==3){$valuecamp=$T[$valuecamp];$a_idtt=$valuecamp;};
if($nnkey==4){$a_cant=$valuecamp;};
if($nnkey==7){$a_est=$valuecamp;};




		
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

echo $queryp . "\n";

if (!$dbnivel->close()){die($dbnivel->error());};


?>

<!--
<script>
	window.location.href = "/importadores/detreparto.php"; 
</script>
-->

