


<?php
require_once("../db.php");
require_once("../variables.php");

$cajt="";
foreach ($tiendas as $idt => $nomt) {
$cajt.="<div class='cajt' id='idt_$idt' onclick='javascript:cajtie($idt);'>$nomt</div>";	
}
$cajt.="<div style='clear:both;'></div>";


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
<script type="text/javascript" src="/js/rebajas.js"></script>
<script type="text/javascript" src="/js/ffecha.js"></script>

</head>


<script>

setCookieT('reb','',1);


function cargasubgrupo (id) {
 $("#4").load("/ajax/subgruposparalist.php?id=" + id); 
}

function listaArticulosC(hago){

if((hago)&&(hago!='l')){var h='h';}else{var h='';};
var prov=document.getElementById(h + '2').value
var grup=document.getElementById(h + '3').value
var subg=document.getElementById(h + '4').value
var colo=document.getElementById(h + '5').value
var codi=document.getElementById(h + '6').value
var pvp=document.getElementById(h + '7').value
var desd=document.getElementById(h + '8').value
var hast=document.getElementById(h + '9').value
var temp=document.getElementById(h + '10').value

if(hago=='l'){
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

var idrebaja=document.getElementById('idrebaja').value;



	
url = "/ajax/addartREB.php?hago=" + hago + "&id_proveedor=" + prov
 + "&id_subgrupo=" + subg
 + "&id_color=" + colo
 + "&codigo=" + codi
 + "&pvp=" + pvp
 + "&desde=" + desd
 + "&id_rebaja=" + idrebaja
 + "&hasta=" + hast
 + "&temporada=" + temp;

if(idrebaja) {
timer(1);	
addArticREB(url);
 }	
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


<div class="rebajasAct">
	
	<div class="newReb">
		
		<div>Agrupación de Rebajas</div>
		<input type="text" id="R_nom" style="font-size:10px; margin-bottom: 5px;  width:129px;">
		<input type="text" id="R_ini" class="ffecha rebfini" value="dd/mm/aaaa" onfocus="javascript:dlF(this.id);" onkeyup="javascript:tabF(this.id);">
		<input type="text" id="R_fin" class="ffecha rebffin" value="dd/mm/aaaa" onfocus="javascript:dlF(this.id);" onkeyup="javascript:tabF(this.id);">
		<div class="boton" style="width:112px; position: absolute; top:59px; "; onclick="creaREB();">Crear</div>
	</div>
	
<div style="clear:both;"></div>	
	
<div class="listReb">
	
	<div class="cabtab_artC" style="width: 185px;">Rebajas Activas</div>
	
</div>

<div style="position: relative;top:5px;">	
<iframe  height="425" width="203" scrolling="auto" frameborder="0" marginheight="0" border="0" src="/ajax/rebajasAct.php" id="FrebAct"></iframe>	
</div>


	
</div>








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
			<td>hasta</td>
			<td><input class="corto" type="text" id="9" /></td>
		</tr>
		
		<tr>
			<td>Temporada</td>
			<td><input class="corto" type="text" id="10" /></td>
		</tr>
		
	</table>
	
	
	<div onclick="listaArticulosC('l');" class="boton">Listar</div>
	
	
	<input type="hidden" id="fini" value="" />
	<input type="hidden" id="ffin" value="" />
	<input type="hidden" id="tisel" value="" />
	<div class="cajastiendas">
		<?php echo $cajt; ?>		
	</div>
	
	<div class="chang">
	
	<input class="corto" type="text" id="amount"style="width:32px; position:relative; float: left; left:29px; top:7px;" /></td>
	<div style="clear:both;"></div>
    
    <div onclick="chPrice(1);" class="boton" 	style="width:7px; position:relative; float: left;">-</div>
	<div  										style="width:38px; position:relative; float: left; text-align: center; padding-top:14px;" >%</div>
	<div onclick="chPrice(2);" class="boton" 	style="width:7px; position:relative; float: left;">+</div>
	<div style="clear:both;"></div>
	
	<div onclick="chPrice(3);" class="boton" 	style="width:7px; position:relative; float: left;">-</div>
	<div  										style="width:38px; position:relative; float: left; text-align: center; padding-top:14px;" >€</div>
	<div onclick="chPrice(4);" class="boton" 	style="width:7px; position:relative; float: left;">+</div>
	<div style="clear:both;"></div>
	
	<div onclick="chPrice(5);" class="boton" 	style="width:20px; position:relative; float: left; left:27px">Fijo</div>
	<div style="clear:both;"></div>
	
	
	</div>

</div>	




	
	


<div style="position:relative; float: left; margin-left:20px;">


<input type="hidden" id="idrebaja" value="" />
	
<div class="cabartC">
	<div class="cabtab_artC tab_artC_codbar" style="width: 91px;">Articulo</div>
	<div class="cabtab_artC tab_artC_cong" style="width: 52px;">PVP</div>
	<div class="cabtab_artC tab_artC_cong" style="width: 52px;">REB</div>
</div>
<iframe id="articulos" src="/ventanas/blank_reb.htm" width="220" height="470" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>

<div style="height: 20px;    position: relative;    width: 248px;">
<div onclick="seltodsR();" class="boton" style="position:relative;float:left; width:98px; margin-right:10px;">Seleccionar todos</div>
<div onclick="borraselR();" class="boton" style="position:relative;float:left; width:95px;">Borrar selección</div>
</div>
<div onclick="enviaTiendas();" class="boton" style="margin-top: 20px;">Enviar a tiendas</div>
	
</div>









<div style="clear:both;"></div>




<div class="timer" id="timer" style="visibility: hidden; left: 65%; top:35%;"><img src="/iconos/loading1.gif"></div>

</body>



</html>