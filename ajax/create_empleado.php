<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select id from empleados ORDER BY id DESC limit 1;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$id=$row['id']+1;};

$queryp= "select id_tienda from tiendas where id=$idt;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$tienda=$row['id_tienda'];};


$queryp= "INSERT INTO empleados (id,id_tienda,trabajando,orden) VALUES ($id,'$tienda','N',0);";

$dbnivel->query($queryp);
if (!$dbnivel->close()){die($dbnivel->error());};

SyncModBDbytien($queryp,$idt);








if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select * from empleados where id_tienda IN (select id_tienda from tiendas where id=$idt) ORDER BY id DESC;";

$listado="";

$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$nombre=$row['nombre'];$apellido1=$row['apellido1'];	$apellido2=$row['apellido2'];	$trabajando=$row['trabajando'];	$orden=$row['orden'];	$ide=$row['id'];
$listado .="
<tr>
<td style='width:160px'><input type='text' class='camp_emp_nombre' value='$nombre' onfocus=\"paraguardar('empleados','aV$ide')\" id='aV$ide'></td>
<td style='width:160px'><input type='text' class='camp_emp_ap1' value='$apellido1' onfocus=\"paraguardar('empleados','bV$ide')\" id='bV$ide'></td>
<td style='width:160px'><input type='text' class='camp_emp_ap2' value='$apellido2' onfocus=\"paraguardar('empleados','cV$ide')\" id='cV$ide'></td>
<td style='width:40px'><input type='text' class='camp_emp_trb' value='$trabajando' onfocus=\"paraguardar('empleados','dV$ide')\" id='dV$ide'></td>
<td style='width:40px'><input type='text' class='camp_emp_ord' value='$orden' onfocus=\"paraguardar('empleados','eV$ide')\" id='eV$ide'></td>
</tr>
	";
	
};

if (!$dbnivel->close()){die($dbnivel->error());};





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="/js/tablas.js"></script>




</head>





<body>

<style>

body {}
table 	{border-collapse:collapse; width:560px; background-color: white;}
tr		{height:20px;  }
td		{width: 90px; border: 1px  solid #888888; margin:0px;}
	
</style>


<table>


<?php echo $listado;?>

</table>