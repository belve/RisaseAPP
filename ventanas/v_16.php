<?php
require_once("../db.php");
require_once("../variables.php");

require_once("../functions/gettiendas.php");
$tip=2;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>test</title>


<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/pedidos.js"></script>



<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body onload="cargaPedGRID();">

<script>
$(window).keydown(function(evt) {
  if (evt.which == 17) { // ctrl
  top.document.getElementById('crtl').value=1;
  }
}).keyup(function(evt) {
  if (evt.which == 17) { // ctrl
  top.document.getElementById('crtl').value=0;
  }
});


</script>	












<input type="hidden" id="tip" value="<?php echo $tip;?>">





	
<div class="cabREP" style="width: 845px;margin-top:0px ">
	<div class="cabtab_REP tab_REP_art">Artículos</div>
	<div class="cabtab_REP tab_REP_rep">REP</div>
	<div class="cabtab_REP tab_REP_alm">ALM</div>

<div id="optCABE">
<?php
$postiendas=0;
foreach($tiendas as $idt => $nomt){
$postiendas++;
echo "<div onclick='sumatienda($postiendas,\"$nomt\")' class='cabtab_REP tab_REP_tie'>$nomt</div>";	
}

?>
</div>
	
</div>
<iframe id="GRID" src="/ajax/grid.php" width="847" height="520" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>

<input type="text" class="medio" id="cod" onchange="addfGrid();"  />





<div class="timer" id="timer4" style="visibility: hidden; left: 520px; top:119px;"><img src="/iconos/loading1.gif"></div>
<div class="timer" id="timer" style="visibility: hidden; left: 520px; top: 200px;"><img src="/iconos/loading1.gif"></div>











	
<!-- GESTIONAR -->







</div>




</body></html>