<?php

if (!$dbnivel->open()){die($dbnivel->error());};

$count=0;;$franq=array();
$queryp= "select id, orden, id_tienda, nombre, franquicia from tiendas where activa=1 ORDER BY orden ASC";

$listado="";

$dbnivel->query($queryp);$liT="";
while ($row = $dbnivel->fetchassoc()){$count++;
	
	$liT.=$row['id'] . ",";
	$idttt=$row['id'];$orden=$row['orden'];$nidtienda=$row['id_tienda'];$f=$row['franquicia'];
	if($orden < 10){$orden="0" . $orden;};
	$tiendas[$idttt]=$nidtienda;
	$tiendasN[$idttt]=$row['nombre'];
	$EQtiendas[$count]=$idttt;
	$EQtiendas2[$idttt]=$count;
	if($f){$franq[$idttt]=1;};
};


if (!$dbnivel->close()){die($dbnivel->error());};
$liT=substr($liT, 0,-1);
?>