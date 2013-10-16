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

if(array_key_exists($idt, $tiendas)){$tindm[$idt]=$tiendas[$idt];};


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


$g=substr($row['codbarras'], 0,1); $sg=substr($row['codbarras'], 1,1); $cod=substr($row['codbarras'],4);
$cb[$g][$sg][$cod]=$ida;
}





ksort($cb);
foreach ($cb as $g => $sgs) {ksort($sgs); foreach ($sgs as $sg => $cods) {ksort($cods); foreach ($cods as $cod => $codb) {
$grid2[$codb]=$grid[$codb];
}}}


$html="";$cabe=array();$rotura=0;

$fila=0;
if(count($grid2)>0){
foreach ($grid2 as $ida => $val){$nomb=$noms[$ida];
$re=$rep[$ida];
$stock=$stocks[$ida];
$stock2=$stock-$re;
$fila++;
if($stock2 < 0){$st=" style='background-color:#F8CDD9;'";$rotura=1;}else{$st="";};

$html.="
<tr id='$ida' $st>

<td style='border-bottom: 1px solid #888888;' ondblclick='ShowDetArt(1,$ida);'>
<div class='camp_REP_art' id='z1'>$nomb</div>
</td>

<td style='width:28px;border-bottom: 1px solid #888888;'>
<div class='camp_REP_rep' id='rep-$ida'>$re</div>
</td>

<td style='width:28px;border-bottom: 1px solid #888888;border-right:2px solid orange;'>
<div class='camp_REP_alm' id='sto-$ida'>$stock2</div>
<input type='hidden' id='stck-$ida' value='$stock'>
<input type='hidden' id='fl-$fila' value='$ida'>
<input type='hidden' id='idgf-$fila' value='$idagrupacion'>
</td>

";

$count=0;$columna=0;



foreach ($tiendas as $idt => $nomc) {if(array_key_exists($idt, $tindm)){
		
$cabe[$nomc]= "<div class='cabtab_REP tab_REP_tie'>$nomc</div>";		
		
		
	$count++;
	$columna++;	
		
			if(array_key_exists($idt, $val)){
			$cant=$val[$idt];$idp=$idpeds[$ida][$idt];	
			}else{
			$cant="";$idp="";	
			}	
			
		if(!$modi){
		$acciones="
		<div class='camp_REP_tie' id='$idp'>$cant</div>
		";	
			
		}else{
		$acciones="
		<input type='text' onfocus='this.select();' value='$cant' class='camp_REP_tie' id='$fila-$columna' onchange='updtPed(\"$idp\",\"$fila-$columna\")' tabindex='$fila-$columna'>
		<input type='hidden' id='t-$fila-$columna' value='$idt'>
		";
		}
		
	$html .="
	
	<td class='' style='width:24px;border-bottom: 1px solid #888888;'>
	
	<input type='hidden' value='' id='d-$idp'>
	$acciones
	</td>
	
	
	";	
	








	
}}


	
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


$valores['cabe']=$cabe2;
$valores['roto']=$rotura;
$valores['html']=$html;
$valores['nagru']=$nagru;
$valores['estado']=$estado;
echo json_encode($valores);

?>



