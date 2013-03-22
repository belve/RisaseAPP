<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="/js/tablas.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>



</head>





<body>

<style>

body {}
table 	{border-collapse:collapse; width:518px; background-color: white;}
tr		{height:20px;  }
td		{width: 90px; border: 1px  solid #888888; margin:0px;}
	
</style>




<?php
$id_proveedor="";$id_subgrupo="";$id_color="";$codigo="";$pvp="";$desde="";$hasta="";$temporada="";
if(count($_GET)>0){
	

	
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$options="";

require_once("../functions/listador.php");### recupera $options

$queryp= "select * from articulos where $options;";

$listado="";

$dbnivel->query($queryp);$count=1;
while ($row = $dbnivel->fetchassoc()){
$codbarras=$row['codbarras'];$refprov=$row['refprov'];	$stock=$row['stock'];	$pvp=$row['pvp'];	$temporada=$row['temporada'];
$stockini=$row['stockini']; $congelado=$row['congelado'];	
$ide=$row['id'];

$listado .="
<tr>
<td style='width:79px'><input type='text' class='camp_art_codbar' value='$codbarras'></td>
<td style='width:114px'><input type='text' class='camp_art_rpro' value='$refprov'></td>
<td style='width:45px'><input type='text' class='camp_art_stock' value='$stock' onchange=\"modifield('articulos','stock','0V$count','$ide')\" id='0V$count'></td>
<td style='width:45px'><input type='text' class='camp_art_pvp'   value='$pvp' onchange=\"modifield('articulos','pvp','1V$count','$ide')\" id='1V$count'></td>
<td style='width:45px'><input type='text' class='camp_art_temp' value='$temporada' onchange=\"modifield('articulos','temporada','2V$count','$ide')\" id='2V$count'></td>
<td style='width:45px'><input type='text' class='camp_art_stini' value='$stockini' onchange=\"modifield('articulos','stockini','3V$count','$ide')\" id='3V$count'></td>
<td style='width:45px'><input type='text' class='camp_art_cong' value='$congelado' onchange=\"modifield('articulos','congelado','4V$count','$ide')\" id='4V$count'></td>

</tr>
	";
$count++;
};

if (!$dbnivel->close()){die($dbnivel->error());};





?>



<table>


<?php echo $listado;?>

</table>

<script>
	$(document).keypress(function(e) {
      switch(e.keyCode) { 
      	
      	 // User pressed "left" arrow
         case 37:
           changefield_art('left'); break;
      	
       // User pressed "right" arrow
         case 39:
           changefield_art('right');break;
      	
         // User pressed "up" arrow
         case 38:
           changefield_art('up'); break;
         
         // User pressed "down" arrow
         case 40:
           changefield_art('down'); break;
         
         // User pressed "enter"
         case 13:
            changefield_art('down'); break;
      }
   });
   

parent.document.getElementById("timer").style.visibility = "hidden";
</script>
</body>
</html>

<?php
}
?>