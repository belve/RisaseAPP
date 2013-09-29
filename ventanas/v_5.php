<?php
require_once("../db.php");
require_once("../variables.php");

if (!$dbnivel->open()){die($dbnivel->error());};


$htmlCol="";
$queryp= "select id, nomcorto from proveedores ORDER BY nomcorto ASC;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$id=$row['id'];$nombre=$row['nomcorto'];
	$htmlCol .="<option value='$id'>$nombre</option>";	
}




if (!$dbnivel->close()){die($dbnivel->error());};


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>test</title>


<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>

<script type="text/javascript" src="/js/bd-basicos.js"></script>


<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body>
<input type="hidden" class="corto" id="1_hid">


<div class="botonera">
	<div class="iconos ini_on" 	onclick="javascrit:cargaproveedores(6);"></div>
	<div class="iconos prev_on" onclick="javascrit:cargaproveedores('menos');"></div>
	<div class="iconos next_on" onclick="javascrit:cargaproveedores('mas');"></div>
	<div class="iconos fin_on" 	onclick="javascrit:cargaproveedores('fin');"></div>
	
	<div style="float: left;left: 4px;position: relative;top: -4px;">
		 <select onchange="javascrit:cargaproveedores(this.value);" id="ccolor"><?php echo $htmlCol; ?> </select> </div>
	
	<div class="iconos save_on" onclick="javascrit:saveproveedores();"></div>
	<div class="iconos new_on" onclick="javascrit:createproveedores();"></div>
</div>

<div style="clear: both;margin-bottom: 10px; "></div>	
<table style="float: left;">
		<tbody>
		
		<tr>
			<td>Código</td>
			<td><input type="text" name="idmost" class="corto" id="1" onchange="javascrit:cargaproveedoresS();" ></td> 
			
		</tr>
		
		<tr>
			<td>Razón Social</td>
			<td><input type="text" name="color" class="largo" id="2"></td>
		</tr>

		<tr>
			<td>NIF</td>
			<td><input type="text" name="color" class="largo" id="3"></td>
		</tr>
		
		<tr>
			<td>Direccion</td>
			<td><input type="text" name="color" class="largo" id="4"></td>
		</tr>
		
		<tr>
			<td>CP</td>
			<td><input type="text" name="color" class="corto" id="5"></td>
		</tr>	
		<tr>	
			<td>Población</td>
			<td><input type="text" name="color" class="largo" id="6"></td>
		</tr>
		
			<tr>
			<td>Provincia</td>
			<td><input type="text" name="color" class="largo" id="7"></td>
		</tr>
		
</tbody>
</table>

<table style="float: left; margin-left: 10px;">
		<tbody>
		
		<tr>
			<td>Contacto</td>
			<td><input type="text" name="idmost" class="largo" id="8" ></td>
		</tr>
		
		<tr>
			<td>Teléfono</td>
			<td><input type="text" name="idmost" class="largo" id="9" ></td>
		</tr>
		
		<tr>
			<td>Fax</td>
			<td><input type="text" name="idmost" class="largo" id="10" ></td>
		</tr>
		
		<tr>
			<td>E-Mail</td>
			<td><input type="text" name="idmost" class="largo" id="11" ></td>
		</tr>
		
		<tr>
			<td>Abreviatura</td>
			<td><input type="text" name="idmost" class="medio" id="12" ></td>
		</tr>

</tbody>
</table>

<div style="clear: both;margin-bottom: 10px; "></div>




</body>


<script>
	cargaproveedores(6);
</script>		