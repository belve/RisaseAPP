<?php

if (!$dbnivel->open()){die($dbnivel->error());};

$count=0;;
$queryp= "select id, orden, id_tienda, nombre from tiendas where activa=1 ORDER BY orden ASC";

$listado="";

$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$count++;
	
	$idttt=$row['id'];$orden=$row['orden'];$nidtienda=$row['id_tienda'];
	if($orden < 10){$orden="0" . $orden;};
	$tiendas[$idttt]=$nidtienda;
	$tiendasN[$idttt]=$row['nombre'];
	$EQtiendas[$count]=$idttt;
	$EQtiendas2[$idttt]=$count;
};

if (!$dbnivel->close()){die($dbnivel->error());};

?>