<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");
$a=1;
while($a <= 20){$valores[$a]="";$a++;};

if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select 
(select nombre from proveedores where proveedores.id=articulos.id_proveedor) as proveedor, 
refprov, 
stock, 
uniminimas, 
temporada, 
preciocosto, 
precioneto, 
preciofran, 
pvp,
detalles,
comentarios, 
congelado, 
codbarras, 
id, 
(select dto1 from proveedores where proveedores.id=articulos.id_proveedor) as dto1, 
(select dto2 from proveedores where proveedores.id=articulos.id_proveedor) as dto2, 
(select nombre from subgrupos where subgrupos.id=articulos.id_subgrupo) as subgru, 
(select nombre from colores where colores.id=articulos.id_color) as color, stockini,  
(select nombre from grupos where grupos.id = (select id_grupo from subgrupos where subgrupos.id=articulos.id_subgrupo)) as gru 
 from articulos where codbarras=$codbarras";



$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	
	if($row['dto1']=".00"){$dto1="";}else{$dto1=$row['dto1'];}
	if($row['dto1']=".00"){$dto2="";}else{$dto2=$row['dto1'];}
	
	$valores[1]=$row['id'];
	$valores[2]=$row['proveedor'];
	$valores[3]=$row['gru'];
	$valores[4]=$row['subgru'];
	$valores[5]=$row['color'];
	$valores[6]=$dto1;
	$valores[7]=$dto2;
	
	$valores[8]=$row['congelado'];
	
	$valores[9]=$row['refprov'];
	$valores[10]=$row['stock'];
	$valores[11]=$row['uniminimas'];
	$valores[12]=$row['temporada'];
	$valores[13]=$row['preciocosto'];
	$valores[14]=$row['precioneto'];
	$valores[15]=$row['preciofran'];
	$valores[16]=$row['pvp'];
	$valores[18]=$row['detalles'];
	$valores[19]=$row['comentarios'];
	$valores[20]=$row['stockini'];
};

if (!$dbnivel->close()){die($dbnivel->error());};



echo json_encode($valores);