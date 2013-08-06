<?php 
$ini=2013;
set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};


##### datos OLD
$Ntab='Pedidos';

$Nid='pti_idPedido';

$camp[1]='pti_idPedido';
$camp[2]='pti_FechaPedido';
$camp[3]='pti_Estado';




##### datos NEW
$nNtab="agrupedidos";

$nNid='id';


$ncamp[1]='nombre';
$ncamp[2]='fecha';
$ncamp[3]='estado';


$conn=odbc_connect('risasenew','edu','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM $Ntab where pti_FechaPedido <= '31/12/$ini' AND pti_FechaPedido >= '01/01/$ini';";


$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}



$count=1;
while (odbc_fetch_row($rs))
  {$count++;


foreach($camp as $nkey => $nomcampo){
	 $valores[$count][$nkey]=trim(utf8_encode(odbc_result($rs,$nomcampo)));
}


  }

odbc_close($conn);

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
$valopi .="($sqlvals,2),";	

}

$valopi=substr($valopi, 0,strlen($valopi)-1);	

$queryp= "INSERT INTO $nNtab ($sqlcamps,tip) values $valopi;";
if($ini <= 2011){$dbnivel->query($queryp);};
#echo $queryp . "\n";



if (!$dbnivel->close()){die($dbnivel->error());};

$ini++;
?>

<script>
	 window.location.href = "/importadores/pedidos.php?ini=<?php echo $ini;?>";
</script>


