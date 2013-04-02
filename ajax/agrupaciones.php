<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />

</head>

<body>

<style>

body {}
table 	{border-collapse:collapse;  background-color: white;}
tr		{height:20px;  }
td		{width: 90px; border: 1px  solid #888888; margin:0px;}
	
</style>


<?php
$agrupar="";$agrupaciones=array();
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");require_once("../functions/gridreparto.php");

$fecha=date('Y') . date('m') . date('d');
$html="";
if (!$dbnivel->open()){die($dbnivel->error());};


if($agrupar){

$queryp= "SELECT distinct(prov) as nprov, 
(select nomcorto from proveedores where id=nprov) as nomcorto 
from pedidos WHERE tip=$tip AND estado='-' GROUP BY id_articulo ORDER BY prov, fecha, grupo, subgrupo, codigo;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$agrupaciones[$row['nprov']]=$row['nomcorto'] . "-" . $fecha;}

if(count($agrupaciones)>0){foreach($agrupaciones as $idpr => $agrupp){
$queryp="update pedidos set agrupar='$agrupp' where prov=$idpr AND tip=$tip AND estado='-';";	
$dbnivel->query($queryp); 
}}
	
}


$queryp= "SELECT distinct(agrupar) as agrupados from pedidos WHERE tip=$tip AND estado='-' GROUP BY id_articulo ORDER BY fecha, grupo, subgrupo, codigo;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
$idagrupado=$row['agrupados'];
$html.= "
<div class='agrup'>$idagrupado</div>
";	
}



if (!$dbnivel->close()){die($dbnivel->error());};





?>





<?php echo $html; ?>


<script>
var url="/ajax/pedipent.php?tip=1";
parent.document.getElementById('pedipent').src=url;
</script>
