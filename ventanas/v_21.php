


<?php
require_once("../db.php");
require_once("../variables.php");

$cajt="";
foreach ($tiendas as $idt => $nomt) {
$cajt.="<div class='cajt' id='idt_$idt' onclick='javascript:cajtie($idt);' ondblclick='tselALL();' >$nomt</div> <script>window.top.tsel[$idt]=0;</script> ";	
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

<script>
window.top.listArts = new Array();
window.top.select   = new Array();
window.top.codbars 	= new Array();
window.top.fijo 	= new Array();
window.top.tienda	= new Array();
window.top.tsel	= new Array();	
window.top.tselALL	=0;	
</script>
<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="/js/focus.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>
<script type="text/javascript" src="/js/fstock.js"></script>
<script type="text/javascript" src="/js/ffecha.js"></script>

</head>


<script>



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


	
url = "/ajax/addartFSTOCK.php?hago=" + hago + "&id_proveedor=" + prov
 + "&id_grupo=" + grup
 + "&id_subgrupo=" + subg
 + "&id_color=" + colo
 + "&codigo=" + codi
 + "&pvp=" + pvp
 + "&desde=" + desd
 + "&hasta=" + hast
 + "&temporada=" + temp;

var yalist="";// window.top.listArts.toString();
url=url  + "&yalistados=" + yalist;

timer(1);	

addArts(url);
limpiaListador();	
}


function limpiaListador(){
document.getElementById('h2').value='';
document.getElementById('h3').value='';
document.getElementById('h4').value='';
document.getElementById('h5').value='';
document.getElementById('h6').value='';
document.getElementById('h7').value='';
document.getElementById('h8').value='';
document.getElementById('h9').value='';
document.getElementById('h10').value='';

document.getElementById('2').value='';
document.getElementById('3').value='';
document.getElementById('4').value='';
document.getElementById('5').value='';
document.getElementById('6').value='';
document.getElementById('7').value='';
document.getElementById('8').value='';
document.getElementById('9').value='';
document.getElementById('10').value='';
	
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
			<td><input class="medio" type="text" id="6"  style="width:95px";/></td>
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
	
	
	<div onclick="listaArticulosC('l');" class="boton">Listar</div>
	
	
	<input type="hidden" id="fini" value="" />
	<input type="hidden" id="ffin" value="" />
	<input type="hidden" id="tisel" value="" />
	<div class="cajastiendas">
		<?php echo $cajt; ?>		
	</div>
	
	<div class="chang">
	
	
	<div style="clear:both;"></div>
    
    <div onclick="res();" class="boton" 	style="width:7px; position:relative; float: left;">-</div>
	<input class="corto" type="text" id="amount"style="width:32px; position:relative; float: left;top:9px;" /></td>
	<div onclick="sum();" class="boton" 	style="width:7px; position:relative; float: left;">+</div>
	<div style="clear:both;"></div>
	<div onclick="fix();" class="boton" 	style="width:20px; position:relative; float: left; left:27px; top:-7px;">Fijo</div>
	<div style="clear:both;"></div>
	
	
	</div>

</div>	




	
	


<div style="position:relative; float: left; margin-left:20px;">


<input type="hidden" id="idrebaja" value="" />
	
<div class="cabartC">
	<div class="cabtab_artC tab_artC_codbar" style="width: 91px;">Articulo</div>
	<div class="cabtab_artC tab_artC_cong" style="width: 52px;">Fijo</div>
	<div class="cabtab_artC tab_artC_cong" style="width: 52px;">Suma</div>
</div>
<iframe id="articulos" src="/ventanas/blank_fstock.htm" width="220" height="470" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>

<div style="height: 20px;    position: relative;    width: 248px;">
<div onclick="seltodsR();" class="boton" style="position:relative;float:left; width:98px; margin-right:10px;">Sel todos</div>
<div onclick="borraselR();" class="boton" style="position:relative;float:left; width:95px;">Borrar selección</div>
</div>
<div class="boton" style="margin-top: 20px; height: 25px; padding:0px;">
	<div class="chkFIJ" onclick="filtFIJ(1);" id="filt_alm">ALM</div>
	<div class="chkFIJ" onclick="filtFIJ(2);" id="filt_bd">BD</div>
	<div class="btoENVfij" onclick="enviaTiendas();" >Enviar a tiendas</div></div>
		<div style="clear:both;"></div>
</div>
<script>
window.top.filtFIj_alm=0;
window.top.filtFIj_bd=0;	
</script>








<div style="clear:both;"></div>




<div class="timer" id="timer" style="visibility: hidden; left: 65%; top:35%;"><img src="/iconos/loading1.gif"></div>

</body>



</html>