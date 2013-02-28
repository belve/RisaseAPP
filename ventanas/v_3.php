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
	<div class="iconos ini_on" onclick="javascrit:cargaGruposINI();"></div>
	<div class="iconos prev_on" onclick="javascrit:cargaGruposMENOS();"></div>
	<div class="iconos next_on" onclick="javascrit:cargaGruposMAS();"></div>
	<div class="iconos fin_on" onclick="javascrit:cargaGruposFIN();"></div>
	
	<div class="iconos save_on" onclick="javascrit:saveGrupo();"></div>
</div>
<div style="clear: both;margin-bottom: 10px; "></div>	
<table>
		<tbody>
		
		<tr>
			<td>Código</td>
			<td><input type="text" name="idmost" class="corto" id="color_id" onchange="javascrit:cargaGruposS();" ></td>
		</tr>
		
		<tr>
			<td>Grupo</td>
			<td><input type="text" name="color" class="largo" id="color_name"></td>
		</tr>

</tbody>
</table>


</body>


<script>
	cargaGrupos(0);
</script>		