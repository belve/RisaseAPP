<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="/js/focus.js"></script>
<script type="text/javascript" src="/js/tiendas.js"></script>
<script type="text/javascript" src="/js/tablas.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>


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

<div style="clear:both;"></div>
<div style="margin-top:20px;position:relative">
	
<div class="cabemp">
	<div class="cabtab_emp nom_tab_emp">NOMBRE</div>
	<div class="cabtab_emp ap1_tab_emp">APELLIDO 1</div>
	<div class="cabtab_emp ap2_tab_emp">APELLIDO 2</div>
	<div class="cabtab_emp trbj_tab_emp">TRB</div>
	<div class="cabtab_emp orde_tab_emp">ORD</div>
</div>
<iframe id="empleados" src="/ventanas/blank.html" width="100%" height="185" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
</div>

<div class="pieemp">
	<div class="iconos save_on" onclick="javascrit:save_tabla('empleados');"></div>
	<div class="iconos new_on" onclick="javascrit:create_empleados();"></div>
</div>
	
</div>




<div class="timer" id="timer" style="visibility: hidden; left: 57%; top:57%;"><img src="/iconos/loading1.gif"></div>
	
<div id="recarga">
<script>
  $("#tiendas").load("/ajax/cargatiendas.php");
</script>


</div>

</body>



</html>