<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$newcod=strtoupper($newcod);

$queryp= "select orden from tiendas where activa=1 ORDER BY orden DESC limit 1;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$ultimo=$row['orden'];};

$queryp= "update tiendas set orden=orden+1 where orden > $ultimo;";
$dbnivel->query($queryp);

$nuevo=$ultimo+1;
$queryp= "INSERT INTO tiendas (id_tienda,activa,orden) values ('$newcod',1,'$nuevo')";
$dbnivel->query($queryp);

$queryp= "select id, orden, id_tienda from tiendas where activa=1 ORDER BY orden ASC";

$listado="";

$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
		
	
	$id=$row['id'];$orden=$row['orden'];$idtienda=$row['id_tienda'];
	if($orden==$nuevo){$class="class='tselected'";}else{$class="";};
	
	if($orden < 10){$orden="0" . $orden;};
	
	$listado .="<li $class id='t-$id' onclick='javascript:cargatiend($id)'>$orden - $idtienda</li>";
	
};

if (!$dbnivel->close()){die($dbnivel->error());};

$listado .="

<script>
cargatiend($id)

</script>

";

echo $listado;


