<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");require_once("../functions/gridreparto.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$rep=array();$grid=array();$nagru="";

$modi=0;
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
	
$idp=$row['id'];$ida=$row['id_articulo'];$idt=$row['id_tienda'];$cant=$row['cantidad'];$nagru=$row['nagru'];$estado=trim($row['estado']);$tip=$row['tip'];

if($row['tip']==1){$todas=1;}else{$todas=0;};


if(($tip == '2')&&($estado=='P')){$modi=1;};
if(($tip == '2')&&($estado=='A')){$modi=1;};

if(!array_key_exists($ida, $rep)){$rep[$ida]=0;};

$idpeds[$ida][$idt]=$idp;
$grid[$ida][$idt]=$cant;
$stocks[$ida]=$row['stock'];
$rep[$ida]=$rep[$ida] + $cant;
$noms[$ida]=$row['codbarras'] . " / " . $row['nomprov'];
$tieacts[$idt]=1;	
}


$html="";$cabe=array();$rotura=0;

$fila=0;
if(count($grid)>0){
foreach ($grid as $ida => $val){$nomb=$noms[$ida];$re=$rep[$ida];$stock=$stocks[$ida];
$fila++;
if($re > $stock){$st=" style='background-color:#F8CDD9;'";$rotura=1;}else{$st="";};

$html.="
<tr id='$ida' $st>

<td style='border-bottom: 1px solid #888888;' ondblclick='ShowDetArt(1,$ida);'>
<div class='camp_REP_art' id='z1'>$nomb</div>
</td>

<td style='width:28px;border-bottom: 1px solid #888888;'>
<div class='camp_REP_rep' id='z2'>$re</div>
</td>

<td style='width:28px;border-bottom: 1px solid #888888;border-right:2px solid orange;'>
<div class='camp_REP_alm' id='z3'>$stock</div>
</td>

";

$count=0;$columna=0;
foreach ($tiendas as $idt => $nomc) {
if(array_key_exists($idt, $val)){
$count++;
$cant=$val[$idt];$idp=$idpeds[$ida][$idt];
$columna++;

if(!$modi){
$acciones="
<div class='camp_REP_tie' id='$idp'>$cant</div>
";	
	
}else{
$acciones="
<input type='text' onfocus='this.select();' value='$cant' class='camp_REP_tie' id='$fila-$columna' onchange='updtPed($idp,\"$fila-$columna\")' tabindex='$fila-$columna'>
";
}

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


	
}



}else{
$queryp= "select nombre, estado from agrupedidos where id=$idagrupacion;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$html="";$nagru=$row['nombre'];$estado=$row['estado'];}
	
	
}




if (!$dbnivel->close()){die($dbnivel->error());};

$cabe2="";
if(count($cabe)>0){foreach($cabe as $nc => $cod){$cabe2.=$cod;};};

if(!$todas){$valores['cabe']=$cabe2;};



$valores['roto']=$rotura;
$valores['html']=$html;
$valores['nagru']=$nagru;
$valores['estado']=$estado;
echo json_encode($valores);

?>



