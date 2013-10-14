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


<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>
<script type="text/javascript" src="/js/tablas.js"></script>
<script type="text/javascript" src="/js/bd-basicos.js"></script>


<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body onload="foc();">


<div style="float: left">
<div>Código de Artículo:&nbsp;&nbsp; <input type="text" id="art" class="medio" onchange="javascrit:addArticulo(this.value);"></div>
<div>Alarma: <input id="alarma" type="text" style="width: 46px;" class="corto" value="70">% </div>
</div>

<div style="float: right; border: 1px solid #888888; padding: 5px; margin-left: 20px;">

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




<div style="clear:both;"></div>





</div>

<div style="clear:both;"></div>


<div id="copiar" style="visibility: hidden;" class="copipaste" >							<div onclick="copiarLIN()" 	class="boton" style="width:100px;float:left;margin:5px 5px 0px 0px;">Copiar</div></div>

<div id="pegar"  style="visibility: hidden;">
	<div onclick="CancelCopy()" 	class="boton" style="width:100px;float:left;margin:5px 5px 0px 0px;">Cancelar copia</div>
	<div onclick="pegarLIN()"	class="boton" style="width:100px;float:left;margin:5px 5px 0px 0px;">Pegar</div>
</div>

<div style="float: right"><div class="boton"  onclick="addArticulo('listador');">Listar</div></div>
<div style="float: right"><div style="margin-right: 6px;" class="boton"  onclick="limpiarGRID('');">Limpiar grid</div></div>
<div style="visibility: hidden" class="delFSELs" id="dfsel"><div style="margin-right: 6px;" class="boton"  onclick="delFIL();">Eliminar seleccionadas</div></div>
<div style="float: right"><div style="margin-right: 232px;" class="boton"  onclick="art_en_REP('');">Artículos en reparto</div></div>


<div style="clear:both;"></div>
<div class="cabREP" style="margin-top:10px;">
	<div class="cabtab_REP tab_REP_art">Artículos</div>
	<div class="cabtab_REP tab_REP_rep">REP</div>
	<div class="cabtab_REP tab_REP_alm">ALM</div>

<?php
$postiendas=0;
foreach($tiendas as $idt => $nomt){
$postiendas++;
echo "<div onclick='sumatienda($postiendas,\"$nomt\")' class='cabtab_REP tab_REP_tie'>$nomt</div>";	
}

?>

	
</div>
<iframe id="repartos" src="/ajax/repartos.php" width="992" height="480" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
<iframe id="print" src="" width="0" height="0" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe>



<div class="timer" id="timer" style="visibility: hidden; left: 47%; top:50%;"><img src="/iconos/loading1.gif"></div>


</body>
</html>

