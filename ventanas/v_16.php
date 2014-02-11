<?php
require_once("../db.php");
require_once("../variables.php");

require_once("../functions/gettiendas.php");
$tip=2;




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
<script type="text/javascript" src="/js/pedidos.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>
<script type="text/javascript" src="/js/tablas.js"></script>
<script type="text/javascript" src="/js/bd-basicos.js"></script>


<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body>

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




<div class="boton" style="position:absolute; left:690px; top:53px;"  onclick="cargaPedGRID();"> Listar </div>

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




<div style="clear:both;"></div>





</div>





<input type="hidden" id="tip" value="<?php echo $tip;?>">





	
<div class="cabREP" style="width: 845px;margin-top:0px; position: absolute;
    top: 101px; ">
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
<iframe style="position:relative; margin-top:35px;" id="GRID" src="/ajax/grid.php" width="847" height="420" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>

<input type="text" class="medio" id="cod" onchange="addfGrid();"  />





<div class="timer" id="timer4" style="visibility: hidden; left: 400px; top:300px;"><img src="/iconos/loading1.gif"></div>
<div class="timer" id="timer" style="visibility: hidden; left: 400px; top: 300px;"><img src="/iconos/loading1.gif"></div>











	
<!-- GESTIONAR -->







</div>




</body></html>