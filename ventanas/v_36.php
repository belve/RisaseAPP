<?php
session_start();
$ussid=$_SESSION['ussid'];
require_once("../db.php");
require_once("../variables.php");





?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>test</title>



<script>
window.top.tsel	= new Array();	
window.top.tselALL	=1;	
</script>



<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>

<script type="text/javascript" src="/js/bd-basicos.js"></script>
<script type="text/javascript" src="/js/informes.js"></script>
<script src="/js/ffecha.js" type="text/javascript"></script>


<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body>





<div style="clear:both;"></div>


<div style="float: left; position: relative; margin-left: 10px;   margin-top: 14px;">	
	
	
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

	
	

<div style="float: left; position: relative">	
	
	<div style=""><input type="text" onkeyup="javascript:tabF(this.id);" onfocus="javascript:dlF(this.id);" id="fini" class="medio" value="dd/mm/aaaa" style="color:#333333;"></div>
	<div style=""><input type="text" style="color:#333333;" onkeyup="javascript:tabF(this.id);" onfocus="javascript:dlF(this.id);" id="ffin" value="dd/mm/aaaa" class="medio"></div>

</div>


	
<div style="clear: both;"></div>

<div class="boton" style=" margin-left: 2px; width: 100px;"; onclick="javascript:informePV();" >Informe >> </div>
</div>





<div style="float: left; position: relative; margin-left: 40px; margin-top: 34px;">
	 
	 <div id="reloj" class="relojCalc" style="visibility: hidden;"><img src="/iconos/loading1.gif"></div>
	 <div id="status" style="font-size: 12px; text-decoration: blink; color: #888888;"></div>
	 

</div>


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

