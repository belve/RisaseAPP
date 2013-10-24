<?php
require_once("../db.php");
require_once("../variables.php");




?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>test</title>






<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>

<script type="text/javascript" src="/js/bd-basicos.js"></script>
<script type="text/javascript" src="/js/informes.js"></script>
<script src="/js/ffecha.js" type="text/javascript"></script>


<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body>





<div style="clear:both;"></div>



<div style="float: left; position: relative; margin-left: 5px;   margin-top: 5px;">	
	
	<div style="color: #444444;">Temporada:</div>
	<div style=""> <input value="t/aa" type="text" class="medio" id="temp" style="color:#bbbbbb;" onfocus="javascript:dlT(this.id);" onkeyup="javascript:tabT(this.id);"></div>
	
	<div class="boton" style=" margin-left: 2px; width: 81px;"; onclick="javascript:informeM('C');" >Compras >> </div>
	<div class="boton" style=" margin-left: 2px; width: 81px;"; onclick="javascript:informeM('S');" >Almacén >> </div>
</div>





<div style="float: left; position: relative; margin-left: 40px; margin-top: 34px;">
	 
	 <div id="reloj" class="relojCalc" style="visibility: hidden;"><img src="/iconos/loading1.gif"></div>
	 <div id="status" style="font-size: 12px; text-decoration: blink; color: #888888;"></div>
	 

</div>


<div class="timer" id="timer" style="visibility: hidden; left: 47%; top:50%;"><img src="/iconos/loading1.gif"></div>

<iframe id="excel" src="" width="0" height="0" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe>
<iframe id="photos" src="" width="0" height="0" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe>


</body>
</html>

