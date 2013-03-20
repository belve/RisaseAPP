


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="/js/focus.js"></script>




</head>




<body>


<div style="position:relative; float: left;">
	
<div class="cabmas">
	
	<div class="cabtab_mas tab_mas_rpro">Ref.Prov</div>
	<div class="cabtab_mas tab_mas_g">G</div>
	<div class="cabtab_mas tab_mas_s">S</div>
	<div class="cabtab_mas tab_mas_color">Color</div>
	<div class="cabtab_mas tab_mas_cantidad">Cantidad</div>
	<div class="cabtab_mas tab_mas_alarma">Alarma</div>
	<div class="cabtab_mas tab_mas_precioC">Precio C</div>
	<div class="cabtab_mas tab_mas_pvp">PVP</div>


</div>
<iframe id="altasmas" src="/ajax/altasmas.php" width="435" height="600" border="0" frameborder="0" marginheight="0" scrolling="yes"></iframe>
</div>

<div style="position:relative; float: left; margin-left: 20px;">
	
<div class="cabmas2" ></div>
<iframe id="codgenerados" src="/ajax/codgenerados.php" width="100" height="600" border="0" frameborder="0" marginheight="0" scrolling="yes"></iframe>
</div>



<div style="margin-left:20px; float:left; ">


<?php
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$htmlProv="<option value=''></option>";
$queryp= "select id, nombre from proveedores ORDER BY nombre ASC;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$id=$row['id'];$nombre=$row['nombre'];
	$htmlProv .="<option value='$id'>$nombre</option>";	
}	





if (!$dbnivel->close()){die($dbnivel->error());};


?>




	<table>
		<tr>
			<td>Proveedor</td>
			<td><select id="2" class="largo">
				<?php echo $htmlProv; ?>
			</select></td>
		</tr>
		
		
		
	</table>
	

	
</div>	






<div style="clear:both;"></div>






</body>



</html>