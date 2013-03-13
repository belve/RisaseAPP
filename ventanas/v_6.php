<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="/js/focus.js"></script>
<script type="text/javascript" src="/js/tiendas.js"></script>




</head>





<body>
<div style="float: left;">	
<div id="list_tiendas" class="blnco_limpio" style="float:left;margin-bottom: 10px;">

<ul id="tiendas">


</ul>	



	
</div>
<input type="hidden" id="seleccionado" value="" />
<input type="hidden" id="seleccionado2" value="" />

<div class="botonera" style="clear:both; ">
	
	<div class="iconos prev_on" onclick="javascrit:ordenatienda('up');"></div>
	<div class="iconos next_on" onclick="javascrit:ordenatienda('dw');"></div>
	
	
	
	<div class="iconos save_on" onclick="javascrit:savetienda();"></div>
	<div class="iconos new_on" onclick="javascrit:createtienda();"></div>
	<div style="float:right;"><input type="text" class="newcod" id="newcod" /></div>
</div>
</div>

<div style="margin-left:20px; float:left; ">
<div style="width:580px; height: 160px; margin-bottom:20px;">



<div style="float: left; width:290px;">	
	<table>
		<tr>
			<td>Código</td>
			<td><input class="corto" text" id="1" /></td>
		</tr>
		
		<tr>
			<td>C.Postal</td>
			<td><input class="corto" type="text" id="3" /></td>
		</tr>
		
		<tr>
			<td>Población</td>
			<td><input class="largo" type="text" id="5" /></td>
		</tr>
		
		<tr>
			<td>Comunidad</td>
			<td><input class="largo" type="text" id="7" /></td>
		</tr>
		
		<tr>
			<td>Telefono</td>
			<td><input class="medio" type="text" id="8" /></td>
		</tr>
	</table>
</div>	




<div style="float: left; width:280px;">	
	<table>
		<tr>
			<td>Nombre</td>
			<td><input class="largo" type="text" id="2" /></td>
		</tr>
		
		<tr>
			<td>Direccion</td>
			<td><input class="largo" type="text" id="4" /></td>
		</tr>
		
		<tr>
			<td>Provincia</td>
			<td><input class="largo"  type="text" id="6" /></td>
		</tr>
		
		<tr>
			<td>Activa</td>
			<td><input  type="checkbox" id="9" /></td>
		</tr>

	</table>
</div>	


	
</div>




	
<div id="recarga">
<script>
  $("#tiendas").load("/ajax/cargatiendas.php");
</script>
</div>

</body>



</html>