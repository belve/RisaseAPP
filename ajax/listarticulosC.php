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
$id_proveedor="";$id_subgrupo="";$id_color="";$codigo="";$pvp="";$desde="";$hasta="";$temporada="";$hago="";
if(count($_GET)>0){
	

	
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$options="";
require_once("../functions/listador.php");### recupera $options


if($hago=='c'){
$queryp= "UPDATE articulos set congelado=1 where $options;";
$dbnivel->query($queryp);	
}


if($hago=='d'){
$queryp= "UPDATE articulos set congelado=0 where $options;";
$dbnivel->query($queryp);	
}



$queryp= "select * from articulos where $options;";

$listado="";

$dbnivel->query($queryp);$count=1;
while ($row = $dbnivel->fetchassoc()){
$codbarras=$row['codbarras'];$refprov=$row['refprov'];	$stock=$row['stock'];	$pvp=$row['pvp'];	$temporada=$row['temporada'];
$stockini=$row['stockini']; $congelado=$row['congelado'];	if($congelado==1){$checked="checked";}else{$checked="";};
$ide=$row['id'];

$listado .="
<tr>
<td style='width:140px'><input type='text' class='camp_artC_codbar' value='$codbarras'></td>
<td style='width:45px'><input type='checkbox' $checked id='$ide' onchange='congeIndi($ide);'></td>

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

function congeIndi(id){

if(document.getElementById(id).checked==true){var check=1;}
if(document.getElementById(id).checked==false){var check=0;}

url = "/ajax/updatefield.php?tabla=articulos&campo=congelado&value=" + check + "&id=" + id;
$.getJSON(url, function(data) {
});
	
}


   

parent.document.getElementById("timer").style.visibility = "hidden";
</script>
</body>
</html>

<?php
}
?>