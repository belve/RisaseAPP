<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");require_once("../functions/gridreparto.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$rep=array();$grid=array();


$queryp= "select id_articulo, id_tienda, cantidad, 
(select stock from articulos where id=id_articulo) as stock, 
(select codbarras from articulos where id=id_articulo) as codbarras, 
(select refprov from articulos where id=id_articulo) as nomprov 
from pedidos where agrupar=$idagrupacion order by prov, grupo, subgrupo, codigo;";

$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	
$ida=$row['id_articulo'];$idt=$row['id_tienda'];$cant=$row['cantidad'];	

if(!array_key_exists($ida, $rep)){$rep[$ida]=0;};

$grid[$ida][$idt]=$cant;
$stocks[$ida]=$row['stock'];
$rep[$ida]=$rep[$ida] + $cant;
$noms[$ida]=$row['codbarras'] . " / " . $row['nomprov'];	
}


$html="";

if(count($grid)>0){
foreach ($grid as $ida => $val){$nomb=$noms[$ida];$re=$rep[$ida];$stock=$stocks[$ida];

if($re > $stock){$st=" style='background-color:#F8CDD9;'";}else{$st="";};
	
$html.="
<tr id='$ida' $st>

<td style='border-bottom: 1px solid #888888;'>
<input type='text' value='$nomb' class='camp_REP_art'>
</td>

<td style='width:28px;border-bottom: 1px solid #888888;'>
<input type='text' value='$re' class='camp_REP_rep'>
</td>

<td style='width:28px;border-bottom: 1px solid #888888;border-right:2px solid orange;'>
<input type='text' value='$stock' class='camp_REP_alm'>
</td>

";

foreach ($tiendas as $idt => $nomc) {

if(array_key_exists($idt, $val)){$cant=$val[$idt];}else{$cant="";};

$html .="

<td class='' style='width:24px;border-bottom: 1px solid #888888;'>

<input type='hidden' value='' id=''>
<input type='text' onfocus='this.select();' value='$cant' class='camp_REP_tie' id=''>
</td>


";	
	
}


	
}}




if (!$dbnivel->close()){die($dbnivel->error());};

$valores['html']=$html;

echo json_encode($valores);

?>



