
<?php
require_once("../db.php");
require_once("../variables.php");

if (!$dbnivel->open()){die($dbnivel->error());};


$htmlCol="<option value=''></option>";
$queryp= "select id, nombre from colores ORDER BY nombre ASC;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$id=$row['id'];$nombre=$row['nombre'];
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
<input type="hidden" name="id" class="corto" id="color_hid">


<div class="botonera">
	<div class="iconos ini_on" onclick="javascrit:cargaColoresINI();"></div>
	<div class="iconos prev_on" onclick="javascrit:cargaColoresMENOS();"></div>
	<div class="iconos next_on" onclick="javascrit:cargaColoresMAS();"></div>
	<div class="iconos fin_on" onclick="javascrit:cargaColoresFIN();"></div>
	
	<div style="float: left;    left: 4px;    position: relative;    top: -4px;"> <select onchange="javascrit:cColoresC();" id="ccolor"><?php echo $htmlCol; ?> </select> </div>
	
	<div class="iconos save_on" onclick="javascrit:saveColor();"></div>
	
	
	
</div>
<div style="clear: both;margin-bottom: 10px; "></div>	
<table>
		<tbody>
		
		<tr>
			<td>Código</td>
			<td><input type="text" name="idmost" class="corto" id="color_id" onchange="javascrit:cargaColoresS();" ></td>
		</tr>
		
		<tr>
			<td>Color</td>
			<td><input type="text" name="color" class="largo" id="color_name"></td>
		</tr>

</tbody>
</table>


</body>


<script>
	cargaColores(0);
</script>		