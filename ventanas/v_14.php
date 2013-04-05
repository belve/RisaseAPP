<?php $tip=1;?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>test</title>


<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/pedidos.js"></script>



<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body>





<div style="float:left">
		
<div class="cabPEPEN" style="margin-top:10px;">
<div class="cabtab_PEPEN tab_PEPEN_art">Artículo</div>
<div class="cabtab_PEPEN tab_PEPEN_rep">REP</div>
</div>

<div style="clear:both;"></div>	
<iframe id="pedipent" src="/ajax/pedipent.php" width="203" height="400" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>

<div style="clear:both;"></div>	




	
<div class="boton" onclick="autoagrupar(<?php echo $tip;?>);">Meter en agrupación >></div>

</div>



<div style="float:left; margin-left:20px;">	
	
<div class="cabPEPEN" style="margin-top:10px;">
<div class="cabtab_PEPEN tab_PEPEN_agr">Agrupaciones</div>	
</div>

<div style="clear:both;"></div>	

<iframe id="agrupaciones" src="/ajax/agrupaciones.php" width="203" height="380" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>

<div class="cabPEPEN" style="height:20px;margin-top: -2px;">
<input style="font-size:10px;" type="text" id="newgrup"><div class="iconos new_on" onclick="newAgrup(<?php echo $tip;?>);"></div>
</div>



<div style="clear:both;"></div>	



<div style="float:left: ">
<div class="boton" onclick="autoagrupar(<?php echo $tip;?>);">Auto-agrupar</div>	
</div>


</div>




<div style="float:left;margin-left:20px; ">
		
<div class="cabPEPEN" style="margin-top:10px;">
<div class="cabtab_PEPEN tab_PEPEN_art">Artículo</div>
<div class="cabtab_PEPEN tab_PEPEN_rep">REP</div>
</div>

<div style="clear:both;"></div>	
<iframe id="pediagrup" src="/ajax/pedipent.php" width="203" height="400" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>

<div style="clear:both;"></div>	




	
<div class="boton" onclick="autoagrupar(<?php echo $tip;?>);"> << Sacar de agrupación </div>

</div>







<iframe id="print" src="" width="0" height="0" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe>
<div class="timer" id="timer1" style="visibility: hidden; left: 9%; top:17%;"><img src="/iconos/loading1.gif"></div>
<div class="timer" id="timer2" style="visibility: hidden; left: 34%; top:17%;"><img src="/iconos/loading1.gif"></div>
<div class="timer" id="timer3" style="visibility: hidden; left: 54%; top:17%;"><img src="/iconos/loading1.gif"></div>

<script>
cargaAgrupados(<?php echo $tip;?>,0);
cargaPendientes(<?php echo $tip;?>);
	
</script>


</body></html>