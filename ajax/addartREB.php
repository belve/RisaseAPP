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
$id_proveedor="";$id_grupo="";$id_subgrupo="";$id_color="";$codigo="";$pvp="";$desde="";$hasta="";$temporada="";$hago="";

$detalles="";
$comentarios="";
$ord=1;
$tab=1;

if(count($_GET)>0){
	

	
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
if($id_rebaja>0){
	
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$options="";

require_once("../functions/listador.php");### recupera $options

	if($hago=="l"){
	$queryp= "select id_articulo from det_rebaja where id_rebaja=$id_rebaja;";$noad="";
	$dbnivel->query($queryp);
	while ($row = $dbnivel->fetchassoc()){$noad .=$row['id_articulo'] . ",";};
	$noad=substr($noad, 0,strlen($noad)-1);
	if($noad){$noad="AND id NOT IN ($noad)";}
	
	$queryp= "select * from articulos where $options $noad;";
	$listado="";
	
	$dbnivel->query($queryp);$count=1;
	while ($row = $dbnivel->fetchassoc()){
		$pvp=$row['pvp'];$ide=$row['id'];
	
	$listado .="($id_rebaja,$ide,$pvp),";
	
	};
	
	$listado=substr($listado, 0,strlen($listado)-1);
	
	$queryp= "insert into det_rebaja (id_rebaja,id_articulo,precio) values $listado;";
	$dbnivel->query($queryp);	
	
	}


$queryp= "select 
id_articulo, precio, 
(select codbarras from articulos where id=id_articulo) as codbarras, 
(select pvp from articulos where id=id_articulo) as pvori from det_rebaja where id_rebaja=$id_rebaja;";

$listado="";

$dbnivel->query($queryp);$count=0;
while ($row = $dbnivel->fetchassoc()){$count++;
$codbarras=$row['codbarras']; $id_articulo=$row['id_articulo']; $pvp=$row['precio']; $pvori=$row['pvori'];	
$listado .="
<tr>
<td style='width:70px'><input type='text' class='camp_artC_codbar' value='$codbarras' 	style='width:80px'></td>
<td style='width:45px'><input type='text' class='camp_artC_codbar' value='$pvori'		style='width:40px; text-align:right;'></td>
<td style='width:45px'><input type='text' class='camp_artC_codbar' value='$pvp'	id='$count'	style='width:40px; text-align:right;'></td>
<input type='hidden' id='c_$count' value='$id_articulo'>
</tr>
	";
		
	
}		
	




if (!$dbnivel->close()){die($dbnivel->error());};





?>



<table>


<?php echo $listado;?>

</table>

<input type='hidden' id='total' value='<?php echo $count;?>'>
<script>


parent.document.getElementById("timer").style.visibility = "hidden";

</script>
</body>
</html>

<?php
}}
?>