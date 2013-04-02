<?php
require_once("../db.php");
require_once("../variables.php");

require_once("../functions/gettiendas.php");




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
<body>


<table style="float: left;">
		<tbody>
		
		
		<tr><td>Código de Artículo:&nbsp;&nbsp; <input type="text" id="art" class="medio" onchange="javascrit:addArticulo(this.value);"> Alarma: <input id="alarma" type="text" style="width: 46px;" class="corto" value="70">%   </td></tr>
		
		</tbody>
</table>




<div class="imprimir">
<div class="impREP">		<div class='boton' onclick="impREP()">Imprimir Reparto</div></div>
<div class="impREPtiend">	<div class='boton' onclick="impREPt()">Imprimir por Tiendas</div></div>
</div>


<div style="clear:both;"></div>
<div class="cabREP" style="margin-top:40px;">
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
<iframe id="repartos" src="/ajax/repartos.php" width="970" height="480" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
<iframe id="print" src="" width="0" height="0" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe>

<div onclick="cambiEstado('A');" class="boton" style="width:100px;float:left;margin:5px 5px 0px 0px;">Pasar a Almacén</div>
<div onclick="cambiEstado('T');" class="boton" style="width:100px;float:left;margin:5px 5px 0px 0px;">Enviar a Tienda</div>

<div class="timer" id="timer" style="visibility: hidden; left: 47%; top:50%;"><img src="/iconos/loading1.gif"></div>


</body>
</html>

