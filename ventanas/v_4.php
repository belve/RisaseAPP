<?php
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$html="";
$queryp= "select * from grupos ORDER BY id ASC;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$id=$row['id'];$nombre=$row['nombre'];
	$html .="<option value='$id'>$nombre</option>";	
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
	<div class="iconos ini_on" 	onclick="javascrit:cargaSubGrupos(1);"></div>
	<div class="iconos prev_on" onclick="javascrit:cargaSubGrupos('menos');"></div>
	<div class="iconos next_on" onclick="javascrit:cargaSubGrupos('mas');"></div>
	<div class="iconos fin_on" 	onclick="javascrit:cargaSubGrupos('fin');"></div>
	
	<div class="iconos save_on" onclick="javascrit:saveSubGrupo();"></div>
	<div class="iconos new_on" onclick="javascrit:createSubGrupo();"></div>
	
</div>
<div style="clear: both;margin-bottom: 10px; "></div>	
<table>
		<tbody>
		
		<tr>
			<td>Código</td>
			<td><input type="text" name="idmost" class="corto" id="1" onchange="javascrit:cargaSubGruposS();" ></td>
		</tr>
		
		<tr>
			<td>Grupo</td>
			<td><select id="2">
				<?php echo $html; ?>
			</select></td>
		</tr>

		<tr>
			<td>Subgrupo</td>
			<td><input type="text" name="color" class="largo" id="3"></td>
		</tr>
		
		<tr>
			<td>Clave</td>
			<td><input type="text" name="color" class="corto" id="4"></td>
		</tr>
		
		
</tbody>
</table>


</body>


<script>
	cargaSubGrupos(1);
</script>		