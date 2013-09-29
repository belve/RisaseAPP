<?php
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$html="";$ocul="";$ocul2="";
$queryp= "select * from grupos ORDER BY id ASC;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$id=$row['id'];$nombre=$row['nombre'];
	$html .="<option value='$id'>$nombre</option>";	
}	


$queryp= "select distinct id_grupo as idg, min(id) as id from subgrupos group by id_grupo ;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$idg=$row['idg'];$idsg=$row['id'];
	$ocul .="<input type='hidden' id='oc_$idg' value='$idsg'>";	
}	


$queryp= "select distinct id_grupo as idg, max(clave) as id from subgrupos group by id_grupo;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$idg=$row['idg']; $idsg=$row['id'];
	$ocul2 .="<input type='hidden' id='oc2_$idg' value='$idsg'>";	
}	



if (!$dbnivel->close()){die($dbnivel->error());};




?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>test</title>


<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>

<script type="text/javascript" src="/js/bd-basicos.js"></script>


<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body>
<input type="hidden" class="corto" id="1_hid">

<div style="border:1px solid #888888; padding: 5px; position: relative;">
<div class="botonera">
	<div class="iconos ini_on" 	onclick="javascrit:cargaSubGrupos(0);"></div>
	<div class="iconos prev_on" onclick="javascrit:cargaSubGrupos('menos');"></div>
	<div class="iconos next_on" onclick="javascrit:cargaSubGrupos('mas');"></div>
	<div class="iconos fin_on" 	onclick="javascrit:cargaSubGrupos('fin');"></div>
	
	<div class="iconos save_on" onclick="javascrit:saveSubGrupo();"></div>
	
	
</div>

<div style="float: left;    left: 4px;    position: relative;    top: -13px;"> 
<select id="2" onchange="javascrit:cSubGru(this.value);" >
				<?php echo $html; ?>
			</select>
</div>

<div style="clear: both;"></div>	
<table>
		<tbody>
		
		<tr>
			<td>Código</td>
			<td><input type="text" style="border:0px; background-color: transparent; width:15px; border-bottom: 1px solid #888888;" name="idmost"  id="1"  readonly>
				<input type="text" style="border:0px; background-color: transparent; width:15px; border-bottom: 1px solid #888888;" name="color"  id="4"  readonly>
			</td>
		</tr>
				
		<tr>
			<td>Nombre</td>
			<td><input type="text" name="color" class="largo" id="3"></td>
		</tr>
		
	
		
		
</tbody>
</table>

</div>

<div style="border:1px solid #888888; padding: 5px; position: relative; margin-top: 10px;">
<select name="csg" id="GforCreate" onchange="javascrit:CreaSubg(this.value);" >
<option value=''></option>	
<?php echo $html; ?>
</select>	

<input type="text" style="border:0px; background-color: transparent; width:15px; border-bottom: 1px solid #888888;" name="idmost"  id="nG"  readonly>
<input type="text" style="border:0px; background-color: transparent; width:15px; border-bottom: 1px solid #888888;" name="color"   id="nSG"  readonly>
<input type="text" name="color" class="medio" id="nName">		
<div class="iconos new_on" onclick="javascrit:createSubGrupo();"></div>
	
</div>





<?php echo $ocul;?>
<?php echo $ocul2;?>


</body>


<script>
	window.top.pointer=0;
	LoadsubG();
	cargaSubGrupos(0);
</script>		