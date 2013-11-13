


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
window.top.listAEL=new Array();

function delRef(){

var List="";
if(window.top.listAEL.length>0){	
if(confirm('Esta seguro que desea eliminar los ' + window.top.listAEL.length + ' artículos')){	
timer(1);

for (a=0; a < window.top.listAEL.length; a++){ List= List + window.top.listAEL[a] + ','; };	

url = "/ajax/delREF.php?list=" + List;

$.getJSON(url, function(data) {
$.each(data, function(key, val) {
if(key=='ok'){
document.getElementById('articulos').src="/ajax/listarticulosR.php";
document.getElementById('2').value="";
document.getElementById('3').value="";
document.getElementById('4').value="";
document.getElementById('5').value="";
document.getElementById('6').value="";
document.getElementById('7').value="";
document.getElementById('8').value="";
document.getElementById('9').value="";
document.getElementById('10').value="";
document.getElementById('11').value="";
document.getElementById('12').value="";
window.top.listAEL=new Array();
timer(0);
 	
}    
});
});

}

}else{alert('No hay artículos seleccionados');}
}



function cargasubgrupo (id) {
 $("#4").load("/ajax/subgruposparalist.php?id=" + id); 
}

function listaArticulosEL(hago){


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
var detalles=document.getElementById(h + '11').value
var comentarios=document.getElementById(h + '12').value


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
document.getElementById('h11').value=detalles
document.getElementById('h12').value=comentarios

}

	
url = "/ajax/listarticulosEL.php?hago=" + hago + "&id_proveedor=" + prov
 + "&id_grupo=" + grup
 + "&id_subgrupo=" + subg
 + "&id_color=" + colo
 + "&codigo=" + codi
 + "&pvp=" + pvp
 + "&desde=" + desd
 + "&hasta=" + hast
 + "&comentarios=" + comentarios
 + "&detalles=" + detalles
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
<input type="hidden" value="" id="h11" />
<input type="hidden" value="" id="h12" />

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
			<td><input class="corto" type="text" id="6" style="width:94px"; /></td>
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
		
		<tr>
			<td>Detalles</td>
			<td><input class="medio" type="text" id="11" /></td>
		</tr>
		
		<tr>
			<td>Comentarios</td>
			<td><input class="medio" type="text" id="12" /></td>
		</tr>
		
		
	</table>
	
	<div style=" float: left;    position: relative;    top: 3px;    width: 160px;" onclick="listaArticulosEL();" class="boton">Listar</div>
	
	
	
	<div style=" float: left;    position: absolute;    top: 380px;    width: 160px;" onclick="delRef();" class="boton">Eliminar</div>
	
	
	
</div>	




	
	


<div style="position:relative; float: left; margin-left:20px;">
	
<div class="cabartC">
	<div class="cabtab_artC tab_artC_codbar"	style="width: 125px;">Articulo</div>
	<div class="cabtab_artC tab_artC_cong"		style="width: 35px;">Cong</div>
	<div class="cabtab_artC tab_artC_cong"		style="width: 30px;">ALM</div>
	
</div>
<iframe id="articulos" src="/ajax/listarticulosR.php" width="220" height="500" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>


	
</div>









<div style="clear:both;"></div>




<div class="timer" id="timer" style="visibility: hidden; left: 65%; top:35%;"><img src="/iconos/loading1.gif"></div>

</body>



</html>