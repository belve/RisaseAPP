<?php
require_once("../db.php");
require_once("../variables.php");

require_once("../functions/gettiendas.php");



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



<title>test</title>


<script>
window.top.listArts =new Array();
window.top.Codbars =new Array();
window.top.pvps	=new Array();
window.top.tiet	=new Array();
window.top.solofij	=0;


</script>

<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>

<script type="text/javascript" src="/js/bd-basicos.js"></script>
<script type="text/javascript" src="/js/fijPVP.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body>




<div style="float: left; border: 1px solid #888888; padding: 5px;">

<div style="float:left;margin-right: 10px;">
<div>Proveedor: <select style="margin-left:0px;" id="2" class="medio"><?php echo $htmlProv; ?></select></div>
<div>Grupo:     <select style="margin-left:22px;" id="3" onchange="cargasubgrupo(this.value);" class="medio">	<?php echo $htmlGrupo; ?></select></div>
<div>Subgrupo:  <select style="margin-left:2px;" id="4" class="medio"><option value=''></option></select></div>
</div>	

<div style="float:left;margin-right: 10px;">
<div>Color: <select style="margin-left:10px;" id="5" class="medio"><?php echo $htmlCol; ?></select></div>
<div>Código: <input  style="margin-left:0px;"class="medio" type="text" id="6" /></div>
<div>Precio: <input  style="margin-left:5px;"class="medio" type="text" id="7" /></div>
</div>	



<div style="float:left;margin-right: 10px;">
<div>Desde: <input  style="margin-left:0px;"class="medio" type="text" id="8" /></div>
<div>Hasta: <input  style="margin-left:4px;"class="medio" type="text" id="9" /></div>
<div>Temp: <input  style="margin-left:6px;"class="medio" type="text" id="10" /></div>
</div>	




<div style="clear:both;"></div>





</div>

<div style="clear:both;"></div>

<div style="float: left">
	<div class="soloFijos" onclick="solofij();" id="divfij">
	<div style="position:relative;float:left;">Mostrar solo articulos con PVP fijo</div>
	<div style="position:relative;float:left;top: -3px; "><input type="checkbox" id="fijCHK"/></div>
	</div>
</div>
<div style="float: left; position:relative; left: 50px;"><div class="boton"  onclick="limpiarGRID();">Limpiar</div></div>
<div style="float: left; position:relative; left: 90px;"><div class="boton"  style="width:100px;"; onclick="addArticulo();">Listar</div></div>

<div style="float: right; position:relative; "><div class="boton"  style="width:100px;"; onclick="envFIJ();">Enviar a tiendas</div></div>


<div style="clear:both;"></div>
<div class="cabREP" style="margin-top:10px;">
	<div class="cabtab_REP tab_REP_art" style="width: 160px;">Artículos</div>
	<div class="cabtab_REP tab_REP_alm">PVP</div>

<?php
$postiendas=0;
foreach($tiendas as $idt => $nomt){
$postiendas++;
echo "<div onclick='sumatienda($postiendas,\"$nomt\")' class='fpvpTIE'>$nomt</div>
<script>window.top.t_$idt =new Array(); window.top.tiet.push($idt);</script>

";	
}

?>

	
</div>
<iframe id="fijosPVP" src="/ventanas/blank_fijPVP.htm" width="992" height="480" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
<iframe id="print" src="" width="0" height="0" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe>



<div class="timer" id="timer" style="visibility: hidden; left: 47%; top:50%;"><img src="/iconos/loading1.gif"></div>


</body>
</html>

