<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");require_once("../functions/gridreparto.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$rep=array();$grid=array();$nagru="";


$queryp= "select id_articulo, id_tienda, cantidad, 
(select nombre from agrupedidos where id=agrupar) as nagru,
(select estado from agrupedidos where id=agrupar) as estado,
(select stock from articulos where id=id_articulo) as stock, 
(select codbarras from articulos where id=id_articulo) as codbarras, 
(select refprov from articulos where id=id_articulo) as nomprov, 
id, tip 
from pedidos where agrupar=$idagrupacion order by prov, grupo, subgrupo, codigo;";

$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	
$idp=$row['id'];$ida=$row['id_articulo'];$idt=$row['id_tienda'];$cant=$row['cantidad'];$nagru=$row['nagru'];$estado=$row['estado'];

if($row['tip']==1){$todas=1;}else{$todas=0;};

if(!array_key_exists($ida, $rep)){$rep[$ida]=0;};

$idpeds[$ida][$idt]=$idp;
$grid[$ida][$idt]=$cant;
$stocks[$ida]=$row['stock'];
$rep[$ida]=$rep[$ida] + $cant;
$noms[$ida]=$row['codbarras'] . " / " . $row['nomprov'];
$tieacts[$idt]=1;	
}


$html="";$cabe=array();

if(count($grid)>0){
foreach ($grid as $ida => $val){$nomb=$noms[$ida];$re=$rep[$ida];$stock=$stocks[$ida];

if($re > $stock){$st=" style='background-color:#F8CDD9;'";}else{$st="";};

$html.="
<tr id='$ida' $st>

<td style='border-bottom: 1px solid #888888;' ondblclick='ShowDetArt(1,$ida);'>
<input type='text' value='$nomb' class='camp_REP_art' id='z1'>
</td>

<td style='width:28px;border-bottom: 1px solid #888888;'>
<input type='text' value='$re' class='camp_REP_rep' id='z2'>
</td>

<td style='width:28px;border-bottom: 1px solid #888888;border-right:2px solid orange;'>
<input type='text' value='$stock' class='camp_REP_alm' id='z3'>
</td>

";

$count=0;
foreach ($tiendas as $idt => $nomc) {

if(array_key_exists($idt, $val)){
$count++;
$cant=$val[$idt];$idp=$idpeds[$ida][$idt];
$acciones="
<input type='text' onfocus='this.select();' value='$cant' class='camp_REP_tie' id='$idp' onchange='updtPed($idp)' tabindex='$count'>
";

$html .="

<td class='' style='width:24px;border-bottom: 1px solid #888888;'>

<input type='hidden' value='' id='d-$idp'>
$acciones
</td>


";	


$cabe[$nomc]= "<div class='cabtab_REP tab_REP_tie'>$nomc</div>";	


}else{
	
$cant="";$idp="";
$acciones="";


if((array_key_exists($idt, $tieacts))||($todas) ){
$html .="

<td class='' style='width:24px;border-bottom: 1px solid #888888;'>

<input type='hidden' value='' id='d-$idp'>
$acciones
</td>


";		
}

}



	
}


	
}}else{
$queryp= "select nombre, estado from agrupedidos where id=$idagrupacion;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$html="";$nagru=$row['nombre'];$estado=$row['estado'];}
	
	
}




if (!$dbnivel->close()){die($dbnivel->error());};

$cabe2="";
if(count($cabe)>0){foreach($cabe as $nc => $cod){$cabe2.=$cod;};};

if(!$todas){$valores['cabe']=$cabe2;};
$valores['html']=$html;
$valores['nagru']=$nagru;
$valores['estado']=$estado;
echo json_encode($valores);

?>



