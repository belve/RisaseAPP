


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


<script>




function cargasubgrupo (id) {
 $("#4").load("/ajax/subgruposparalist.php?id=" + id); 
}

function listaArticulosC(hago){
timer(1);
if(hago){var h='h';}else{var h='';};
var prov=document.getElementById(h + '2').value
var grup=document.getElementById(h + '3').value
var subg=document.getElementById(h + '4').value
var colo=document.getElementById(h + '5').value
var codi=document.getElementById(h + '6').value
var pvp=document.getElementById(h + '7').value
var desd=document.getElementById(h + '8').value
var hast=document.getElementById(h + '9').value
var temp=document.getElementById(h + '10').value

if(hago){}else{
document.getElementById('h2').value=prov
document.getElementById('h3').value=grup
document.getElementById('h4').value=subg
document.getElementById('h5').value=colo
document.getElementById('h6').value=codi
document.getElementById('h7').value=pvp
document.getElementById('h8').value=desd
document.getElementById('h9').value=hast
document.getElementById('h10').value=temp
}

	
url = "/ajax/listarticulosC.php?hago=" + hago + "&id_proveedor=" + prov
 + "&id_subgrupo=" + subg
 + "&id_color=" + colo
 + "&codigo=" + codi
 + "&pvp=" + pvp
 + "&desde=" + desd
 + "&hasta=" + hast
 + "&temporada=" + temp;
 
 document.getElementById('articulos').src=url;
 	
}
  
</script>


<body>
	
<input type="hidden" value="" id="h2" />	
<input type="hidden" value="" id="h3" />
<input type="hidden" value="" id="h4" />
<input type="hidden" value="" id="h5" />
<input type="hidden" value="" id="h6" />
<input type="hidden" value="" id="h7" />
<input type="hidden" value="" id="h8" />
<input type="hidden" value="" id="h9" />
<input type="hidden" value="" id="h10" />

<div style=" float:left; ">

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
			<td><input class="corto" type="text" id="6" /></td>
		</tr>
		
		<tr>
			<td>Precio</td>
			<td><input class="corto" type="text" id="7" /></td>
		</tr>
		
		<tr>
			<td>Desde</td>
			<td><input class="corto" type="text" id="8" /></td>
		</tr>
		
		<tr>
			<td>Hasta</td>
			<td><input class="corto" type="text" id="9" /></td>
		</tr>
		
		<tr>
			<td>Temporada</td>
			<td><input class="corto" type="text" id="10" /></td>
		</tr>
		
	</table>
	
	
	<div onclick="listaArticulosC('');" class="boton">Listar</div>
	
	<div onclick="listaArticulosC('c');" class="boton" style="margin-top: 172px;">Congelar Listado</div>
	<div onclick="listaArticulosC('d');" class="boton">Descongelar Listado</div>
	
</div>	




	
	


<div style="position:relative; float: left; margin-left:20px;">
	
<div class="cabartC">
	<div class="cabtab_artC tab_artC_codbar">Articulo</div>

	<div class="cabtab_artC tab_artC_cong">Cong</div>
</div>
<iframe id="articulos" src="/ajax/listarticulosC.php" width="220" height="500" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>


	
</div>









<div style="clear:both;"></div>




<div class="timer" id="timer" style="visibility: hidden; left: 65%; top:35%;"><img src="/iconos/loading1.gif"></div>

</body>



</html>