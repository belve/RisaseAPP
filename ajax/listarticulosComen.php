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
table 	{border-collapse:collapse; width:200px; background-color: white;}
tr		{height:20px;  }
td		{width: 90px; border: 1px  solid #888888; margin:0px;}
	
</style>




<?php
$id_proveedor="";$id_grupo="";$id_subgrupo="";$id_color="";$codigo="";$pvp="";$desde="";$hasta="";$temporada="";$h="";$optionsdo="";$text="";

$detalles="";
$comentarios="";
$ord=1;
$tab=1;

if(count($_GET)>0){
	

	
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");
$text=addslashes($text);

if (!$dbnivel->open()){die($dbnivel->error());};


$options="";$forsync="";
require_once("../functions/listador.php");### recupera $options

$alerta="";
if(($h=='c')&&($optionsdo)){
$queryp= "UPDATE articulos set comentarios='$text' where $optionsdo;";
$dbnivel->query($queryp);	$forsync=$queryp;
$alerta="Comentarios";
}


if(($h=='d')&&($optionsdo)){
$queryp= "UPDATE articulos set detalles='$text' where $optionsdo;";
$dbnivel->query($queryp);	$forsync=$queryp;
$alerta="Detalles";
}



$queryp= "select id, codbarras, refprov, congelado, 
substring(codbarras,1,1) as g, substring(codbarras,2,1) as sg , substring(codbarras,5) as cod 
from articulos where $options ORDER BY g, sg, cod;";

$listado="";

$dbnivel->query($queryp);$count=1;
while ($row = $dbnivel->fetchassoc()){
$codbarras=$row['codbarras'];$refprov=$row['refprov'];	
$congelado=$row['congelado'];	if($congelado==1){$checked="checked";}else{$checked="";};
$ide=$row['id'];



$listado .="
<tr>
<td style='width:140px'><input type='text' class='camp_artC_codbar' value='$codbarras / $refprov'></td>
</tr>
	";
$count++;
};

if (!$dbnivel->close()){die($dbnivel->error());};

if($forsync){SyncModBD($forsync);};



?>



<table>


<?php echo $listado;?>

</table>

<script>
	parent.document.getElementById('options').value='<?php echo $options; ?>';
	parent.document.getElementById("timer").style.visibility = "hidden";
	
	<?php
	if($alerta){echo "alert('$alerta enviados correctamente')";};
	?>
	
</script>

</body>
</html>

<?php
}
?>