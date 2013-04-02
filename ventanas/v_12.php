<?php
require_once("../db.php");
require_once("../variables.php");






?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>Estado de repartos</title>


<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>
<script type="text/javascript" src="/js/tablas.js"></script>



<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body>





<div style="margin-top:10px;"></div>
<div class="cabLREP">
	<div class="cabtab_LREP tab_LREP_art">Nº Reparto</div>
	<div class="cabtab_LREP tab_LREP_rep">Fecha</div>
	<div class="cabtab_LREP tab_LREP_alm">Estado</div>
</div>

<iframe id="repartos" src="/ventanas/blank.html" width="380" height="480" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>



<div style="margin-top: 5px;"><input onchange="marcListRep();" type="checkbox" id='1' /> Ver sólo repartos activos. <input onchange="marcListRep();" type="checkbox" id='2' /> Ocultar finalizados. </div>
<div style="margin-left: 5px; margin-top: 5px;">Mostrar repartos desde: <input onchange="marcListRep();" type="text" class="medio" id='3' onkeyup="addSlashes(this);" /></div>




<div class="timer" id="timer" style="visibility: hidden; left: 45%; top:25%;"><img src="/iconos/loading1.gif"></div>





</body>
</html>

