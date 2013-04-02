

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

<script>
function autoagrupar(){
var url="/ajax/agrupaciones.php?tip=1&agrupar=1";
document.getElementById('agrupaciones').src=url;	
} 
</script>

<div style="float:left">	
<div class="cabPEPEN" style="margin-top:10px;">
<div class="cabtab_PEPEN tab_PEPEN_art">Artículo</div>
<div class="cabtab_PEPEN tab_PEPEN_rep">REP</div>
</div>
<div style="clear:both;"></div>	
<iframe id="pedipent" src="/ajax/pedipent.php?tip=1" width="208" height="480" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
</div>

<div style="float:left">
<div class="boton" onclick="autoagrupar()">Auto-agrupar</div>	
</div>

<div style="float:left">	
<div class="cabPEPEN" style="margin-top:10px;"></div>
<div style="clear:both;"></div>	
<iframe id="agrupaciones" src="/ajax/agrupaciones.php?tip=1" width="208" height="480" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
</div>


<iframe id="print" src="" width="0" height="0" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe>
<div class="timer" id="timer" style="visibility: hidden; left: 47%; top:50%;"><img src="/iconos/loading1.gif"></div>





</body></html>