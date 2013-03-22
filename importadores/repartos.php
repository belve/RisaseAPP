<?php
set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};


##### datos OLD
$Ntab='Repartos';

$Nid='art_idArticulo';

$camp[1]='rep_NumeroRep';
$camp[2]='rep_fecha';
$camp[3]='rep_estado';




##### datos NEW
$nNtab="repartos";

$nNid='id';


$ncamp[1]='nomrep';
$ncamp[2]='fecha';
$ncamp[3]='estado';


$conn=odbc_connect('risase','edu','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM $Ntab where rep_fecha <= '31/12/2010' AND rep_fecha >= '01/11/2010';";


$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}



$count=1;
while (odbc_fetch_row($rs))
  {


foreach($camp as $nkey => $nomcampo){$count++;
	 $valores[$count][$nkey]=trim(utf8_encode(odbc_result($rs,$nomcampo)));
}


  }

odbc_close($conn);

require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};

print_r($valores);

foreach ($valores as $val1 => $val2) {


$sqlcamps="";$sqlvals="";
foreach ($val2 as $nnkey => $valuecamp)	{
	
	$sqlcamps .= "$ncamp[$nnkey],";
	$sqlvals .= "'$valuecamp',";
}
	
$sqlcamps=substr($sqlcamps, 0,strlen($sqlcamps)-1);	
$sqlvals=substr($sqlvals, 0,strlen($sqlvals)-1);	
	
$queryp= "INSERT INTO $nNtab ($sqlcamps) values ($sqlvals);";
#$dbnivel->query($queryp);
}

if (!$dbnivel->close()){die($dbnivel->error());};


?>
<!--
<script>
	 window.location.href = "/importadores/articulos.php?ini=<?php echo $fin;?>";
</script>
-->

