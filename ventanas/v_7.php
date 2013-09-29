


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="/js/focus.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>



</head>





<body>


<div style="position:relative; float: left;">
	
<div class="cabart">
	<div class="cabtab_art tab_art_codbar" onclick="javascript:tbord(1);" >C.Barras</div>	<input type="hidden" id="t1" value="1">
	<div class="cabtab_art tab_art_rpro" onclick="javascript:tbord(2);" >Ref.Prov</div>		<input type="hidden" id="t2" value="1">
	<div class="cabtab_art tab_art_stock" onclick="javascript:tbord(3);" >Stock</div>		<input type="hidden" id="t3" value="1">
	<div class="cabtab_art tab_art_pvp" onclick="javascript:tbord(4);" >PVP</div>			<input type="hidden" id="t4" value="1">
	<div class="cabtab_art tab_art_pco" onclick="javascript:tbord(5);" >P.Costo</div>			<input type="hidden" id="t5" value="1">
	<div class="cabtab_art tab_art_temp" onclick="javascript:tbord(6);" >Temp</div>			<input type="hidden" id="t6" value="1">
	<div class="cabtab_art tab_art_stini" onclick="javascript:tbord(7);" >Stock Ini</div>	<input type="hidden" id="t7" value="1">
	<div class="cabtab_art tab_art_cong" onclick="javascript:tbord(8);" >Cong</div>			<input type="hidden" id="t8" value="1">
	
</div>

<script>
function tbord(tab){
if(document.getElementById('t' + tab).value==1)
{
	var ord=1;document.getElementById('t' + tab).value=2;
}else{
	var ord=2;document.getElementById('t' + tab).value=1;
}		

listaArticulos(tab,ord);		
		
}
</script>


<iframe id="articulos" src="/ajax/listarticulos.php" width="537" height="500" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>


	
</div>





<div style="margin-left:20px; float:left; ">


<?php
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$htmlProv="<option value=''></option>";
$queryp= "select id, nombre from proveedores ORDER BY nombre ASC;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$id=$row['id'];$nombre=$row['nombre'];
	$htmlProv .="<option value='$id'>$nombre</option>";	
}	



$htmlGrupo="<option value=''></option>";
$queryp= "select id, nombre from grupos ORDER BY id ASC;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$id=$row['id'];$nombre=$row['nombre'];
	$htmlGrupo .="<option value='$id'>$nombre</option>";	
}



$htmlCol="<option value=''></option>";
$queryp= "select id, nombre from colores ORDER BY nombre ASC;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$id=$row['id'];$nombre=$row['nombre'];
	$htmlCol .="<option value='$id'>$nombre</option>";	
}




if (!$dbnivel->close()){die($dbnivel->error());};


?>




	<table>
		<tr>
			<td>Proveedor</td>
			<td><select id="2" class="medio">
				<?php echo $htmlProv; ?>
			</select></td>
		</tr>
		
		<tr>
			<td>Grupo</td>
			<td><select id="3" onchange="cargasubgrupo(this.value);" class="medio">
				<?php echo $htmlGrupo; ?>
			</select></td>
		</tr>
		
		<tr>
			<td>Subgrupo</td>
			<td><select id="4" class="medio">
			<option value=''></option>	
			</select></td>
		</tr>
		
		<tr>
			<td>Color</td>
			<td><select id="5" class="medio">
				<?php echo $htmlCol; ?>
			</select></td>
		</tr>
		
		<tr>
			<td>Código</td>
			<td><input class="medio" type="text" id="6" /></td>
		</tr>
		
		<tr>
			<td>Precio</td>
			<td><input class="medio" type="text" id="7" /></td>
		</tr>
		
		<tr>
			<td>Desde</td>
			<td><input class="corto" type="text" id="8" /></td>
		</tr>
		
		<tr>
			<td>hasta</td>
			<td><input class="corto" type="text" id="9" /></td>
		</tr>
		
		<tr>
			<td>Temporada</td>
			<td><input class="medio" type="text" id="10" /></td>
		</tr>
		
		
		<tr>
			<td>Detalles</td>
			<td><input class="medio" type="text" id="11" /></td>
		</tr>
		
		<tr>
			<td>Comentarios</td>
			<td><input class="medio" type="text" id="12" /></td>
		</tr>
		
		
		
	</table>
	
	
	<div onclick="listaArticulos(1,1);" class="boton">Listar</div>
	<div onclick="limpiaAB();" class="boton">Limpiar</div>
</div>	






<div style="clear:both;"></div>




<div class="timer" id="timer" style="visibility: hidden; left: 35%; top:35%;"><img src="/iconos/loading1.gif"></div>

</body>



</html>