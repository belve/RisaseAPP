<?php


require_once("../db.php");
require_once("../variables.php");
require_once("../functions/gridreparto.php");

$nomrep="";$id="";$html="";$grid=array();$estado="";$nomrep2="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

if (!$dbnivel->open()){die($dbnivel->error());};

if($nomrep){$queryp= "select id, estado from repartos where nomrep='$nomrep'";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id=$row['id'];$estado=$row['estado'];};
}


if((!$id)&&($nomrep)){$nomrep2="<div class='repnue'>Reparto $nomrep creado. Insterte articulos.</div>";	
$date=date('Y') . "-" . date('m') . "-" . date('d');	
$queryp= "INSERT INTO repartos (nomrep,fecha,estado) VALUES ('$nomrep','$date','')";
$dbnivel->query($queryp); 
$queryp= "SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$id=$row['id'];};
}else{

$queryp= "select 
(select codbarras from articulos where articulos.id=detreparto.id_articulo) as codbarras,
(select refprov from articulos where articulos.id=detreparto.id_articulo) as refprov, 
id_articulo, 
cantidad, 
estado,
recibida, 
stockmin, 
(select stock from articulos where articulos.id=detreparto.id_articulo) as stock, 
(select pvp from articulos where articulos.id=detreparto.id_articulo) as pvp, 
id_tienda
from detreparto where id_reparto=$id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$grid[$row['id_articulo']][$row['id_tienda']]['cantidad']=$row['cantidad'];	
$grid[$row['id_articulo']][$row['id_tienda']]['recibida']=$row['recibida'];	
$grid[$row['id_articulo']][$row['id_tienda']]['alarma']=$row['stockmin'];
$grid[$row['id_articulo']][$row['id_tienda']]['estado']=$row['estado'];	
$grid[$row['id_articulo']][$row['id_tienda']]['id']=$row['id_tienda'];	
$dart[$row['id_articulo']]['codbarras']=$row['codbarras'];	
$dart[$row['id_articulo']]['refprov']=$row['refprov'];	
$dart[$row['id_articulo']]['stock']=$row['stock'];			
}
	
}	





if (!$dbnivel->close()){die($dbnivel->error());};

$lastid=0;
if(count($grid)>0){
foreach ($grid as $idarticulo => $dtiendas) {$lastid++;
$valores=GenerateGrid($idarticulo,$dtiendas,$lastid,$dart);	
$html .=$valores['html'];
}}elseif($id){
$nomrep2="<div class='repnue'>Reparto $nomrep creado. Insterte articulos.</div>";		
}


$numtiendas=count($tiendas);

if(array_key_exists($estado, $equiEST)){$estado=$equiEST[$estado];};
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/js/tablas.js"></script>
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />




</head>





<body>

<style>

body {}
table 	{border-collapse:collapse;  background-color: white;}
tr		{height:20px;  }
td		{width: 90px; border: 1px  solid #888888; margin:0px;}
	
</style>


<div id="repnue">
<?php echo $nomrep2; ?> 
</div>


<input type="hidden" id="filsel" value="">
<input type="hidden" id="idrep" value="<?php echo $id; ?>">
<input type="hidden" id="filas" value="<?php echo $lastid; ?>">
<input type="hidden" id="columnas" value="<?php echo $numtiendas; ?>">

<table id='gridRepartos'>

<?php echo $html; ?>


</table>

<script>




$(document).keypress(function(e) {
      switch(e.keyCode) { 
      	
      	 // User pressed "left" arrow
         case 37:
           moveFieldRepart('left'); break;
      	
       // User pressed "right" arrow
         case 39:
           moveFieldRepart('right');break;
      	
         // User pressed "up" arrow
         case 38:
           moveFieldRepart('up'); break;
         
         // User pressed "down" arrow
         case 40:
           moveFieldRepart('down'); break;
         
         // User pressed "enter"
         case 13:
            moveFieldRepart('down'); break;
      }
   });
 

	estadoT('<?php echo $estado;?>');
	parent.document.getElementById("timer").style.visibility = "hidden";
</script>

</body>
</html>
