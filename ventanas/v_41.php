<?php
require_once("../db.php");
require_once("../variables.php");

require_once("../functions/gettiendas.php");


$cajt="";
foreach ($tiendas as $idt => $nomt) {
$cajt.="<div class='cajt' id='idt_$idt' onclick='javascript:cajtie($idt);' ondblclick='tselALL();' >$nomt</div> <script>window.top.tsel[$idt]=0;</script> ";	
}
$cajt.="<div style='clear:both;'></div>";

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>test</title>



<script>
window.top.tsel	= new Array();	
window.top.tselALL	=0;	
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

<div class="cajastiendas" style="position: relative; float: left;">
		<?php echo $cajt; ?>		
</div>

<div style="float: left; position: relative; margin-left: 10px;   margin-top: 15px;">	
	
	<div style=""> <input value="dd/mm/aaaa" type="text" class="medio" id="fini" onfocus="javascript:dlF(this.id);" onkeyup="javascript:tabF(this.id);"></div>
	<div style=""> <input class="medio" value="dd/mm/aaaa" type="text" id="ffin" onfocus="javascript:dlF(this.id);" onkeyup="javascript:tabF(this.id);" style="color:#333333;"></div>
	
	<div >
		<div id="BotR" class="BotRD" style="background-color:#8DC29E;" onclick="botRD('rot');">ROT</div> <div id="BotD" class="BotRD" onclick="botRD('dev');">DEV</div>
		<div style="clear:both;"></div>
	</div>
	<script>
		window.top.brot=1;
		window.top.bdev=0;
	</script>
	<div class="boton" onclick="javascript:informeR();" >Informe >> </div>
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

