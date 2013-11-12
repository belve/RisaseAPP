<?php
session_start();
$ussid=$_SESSION['ussid'];
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



</script>

<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>

<script type="text/javascript" src="/js/bd-basicos.js"></script>
<script type="text/javascript" src="/js/informes.js"></script>
<script src="/js/ffecha.js" type="text/javascript"></script>


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

<div style="float:left;margin-right: 10px;">
<div>Det: <input  style="margin-left:11px; width: 120px;"class="medio" type="text" id="11" /></div>
<div>Com: <input  style="margin-left:4px; width: 120px;"class="medio" type="text" id="12" /></div>
</div>	




</div>

<div style="clear:both;"></div>

<div style="float: left; border: 1px solid #888888; padding: 5px; margin-top: 10px;">
	
	
	
<div style="float: left; position: relative">	
	
	<div style="">Desde: <input value="dd/mm/aaaa" type="text" class="medio" id="fini" onfocus="javascript:dlF(this.id);" onkeyup="javascript:tabF(this.id);"></div>
	<div style="">Hasta: <input class="contH medio" value="dd/mm/aaaa" type="text" id="ffin" onfocus="javascript:dlF(this.id);" onkeyup="javascript:tabF(this.id);" style="color:#333333;"></div>

</div>

</div>

<div style="position:relative; float:left; width:130px; height: 50px; margin-top: 6px; margin-left:10px;">


	
<?php if($ussid['ra']){   ?>	
	<div style=" margin-bottom: 14px;">
		<div id="bRISASA" class="risaB" onclick="risa();">RISASA</div> 
		<div id="bRISASE" class="risaB" style="background-color:#8DC29E;" onclick="risa();">RISASE</div>
		<div style="clear:both;"></div>
	</div>
<? } ?>

	<script>
		window.top.bRISASA=0;
	</script>
	

<div style="position: absolute; left: -1px; top: 46px;">
<div class="ordenadores" onclick="javascript:VorD(1);">GS	<div id="V|1|A" class="icf_up" style="visibility: visible;"></div><div id="V|1|D" class="icf_dw" style="visibility: hidden;"></div> </div>
<div class="ordenadores" onclick="javascript:VorD(3);">VT	<div id="V|3|A" class="icf_up" style="visibility: hidden;"></div><div id="V|3|D" class="icf_dw" style="visibility: hidden;"></div> </div>
<input type="hidden" id="V|4|A" >
<input type="hidden" id="V|2|A">
<input type="hidden" id="V|4|D" >
<input type="hidden" id="V|2|D">
<!--
<div class="ordenadores" onclick="javascript:VorD(4);">%T	<div id="V|4|A" class="icf_up" style="visibility: hidden;"></div><div id="V|4|D" class="icf_dw" style="visibility: hidden;"></div> </div>
<div class="ordenadores" onclick="javascript:VorD(2);">BU	<div id="V|2|A" class="icf_up" style="visibility: hidden;"></div><div id="V|2|D" class="icf_dw" style="visibility: hidden;"></div> </div>
-->

</div>	

</div>


<div style="float: left; position: relative; margin-left: 5px; margin-top: 7px;">
	
	
	<div class="boton" onclick="javascript:informeVPT();" style="margin-top: 3px; height:18px;" >Informe >> </div>

</div>


<div style="float: left; position: relative; margin-left: 40px; margin-top: 34px;">
	 
	 <div id="reloj" class="relojCalc" style="visibility: hidden;"><img src="/iconos/loading1.gif"></div>
	 <div id="status" style="font-size: 12px; text-decoration: blink; color: #888888;"></div>
	 

</div>

<div id="mphotos" class="mphotos" style="visibility: hidden;"></div>

<div class="timer" id="timer" style="visibility: hidden; left: 47%; top:50%;"><img src="/iconos/loading1.gif"></div>

<iframe id="excel" src="" width="0" height="0" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe>
<iframe id="photos" src="" width="0" height="0" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe>

<script>
	window.top.OrdV=1;
	window.top.OrdVO='A';
	
	window.top.VOrdV=1;
	window.top.VOrdVO='A';	
</script>
</body>
</html>

