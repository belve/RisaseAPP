<?php
session_start();
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");require_once("../functions/gridreparto.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "delete from pedidos where cantidad=0;";
$dbnivel->query($queryp);


$rep=array();$grid=array();$nagru="";$NFhtml="";

$modi=0;$todas=""; $rotis=array();
$sumav=array();$sumREP=0;


if($idagrupacion=='GRID'){
	
$options="";$idsabuscar="";
$tab=1;$ord=1;
require_once("../functions/listador.php");	


if($options){
$quer2= "select id from articulos where $options;";		
$dbnivel->query($quer2); 

while ($row = $dbnivel->fetchassoc()){$idsabuscar .=$row['id'] . ",";};
$idsabuscar=substr($idsabuscar,0,strlen($idsabuscar)-1);
$options="AND id_articulo IN ($idsabuscar)";


}

	
$queryp= "select id_articulo, id_tienda, sum(cantidad) as cantidad, 
(select nombre from agrupedidos where id=agrupar) as nagru,
(select estado from agrupedidos where id=agrupar) as estado,
(select stock from articulos where id=id_articulo) as stock, 
(select codbarras from articulos where id=id_articulo) as codbarras, 
(select refprov from articulos where id=id_articulo) as nomprov, 
id, tip 
from pedidos where estado='A' AND tip=2 $options GROUP BY id_articulo, id_tienda;";

$todas=0;
	
}else{
	
$queryp= "select tip from agrupedidos where id=$idagrupacion;";
$dbnivel->query($queryp);$cb=array();
while ($row = $dbnivel->fetchassoc()){
if($row['tip']==1){$todas=1;}else{$todas=0;};
}	
	
	
$queryp= "select id_articulo, id_tienda, sum(cantidad) as cantidad, 
(select nombre from agrupedidos where id=agrupar) as nagru,
(select estado from agrupedidos where id=agrupar) as estado,
(select stock from articulos where id=id_articulo) as stock, 
(select codbarras from articulos where id=id_articulo) as codbarras, 
(select refprov from articulos where id=id_articulo) as nomprov, 
id, tip 
from pedidos where agrupar=$idagrupacion GROUP BY id_articulo, id_tienda;";
}


$dbnivel->query($queryp);$cb=array();
while ($row = $dbnivel->fetchassoc()){
	
$idp=$row['id'];$ida=$row['id_articulo'];$idt=$row['id_tienda'];$cant=$row['cantidad'];$nagru=$row['nagru'];$estado=trim($row['estado']);$tip=$row['tip'];

if(array_key_exists($idt, $tiendas)){$tindm[$idt]=$tiendas[$idt];};






if(($tip == '2')&&($estado=='P')){$modi=1;};
if(($tip == '2')&&($estado=='A')){$modi=1;};

if(!array_key_exists($ida, $rep)){$rep[$ida]=0;};

$idpeds[$ida][$idt]=$idp;
$grid[$ida][$idt]=$cant;
$stocks[$ida]=$row['stock'];
$rep[$ida]=$rep[$ida] + $cant;
$noms[$ida]=$row['codbarras'] . " / " . $row['nomprov'];

$nomis[$ida]=$row['nomprov'];
$codis[$ida]=$row['codbarras'];
$tieacts[$idt]=1;	


$g=substr($row['codbarras'], 0,1); $sg=substr($row['codbarras'], 1,1); $cod=substr($row['codbarras'],4);
$cb[$g][$sg][$cod]=$ida;
}

$rep2=array();
#############3 saco lo que se esta repartiendo de ese articulo no finalizado este en reparto o pedido
$queryp="select id_articulo, sum(cantidad) as rep from pedidos where (estado != 'F' AND estado !='T' AND estado !='-' AND estado !='P') GROUP BY id_articulo;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$rep2[$row['id_articulo']]=$row['rep'];
}



$grid2=array();
if(count($cb)>0){
ksort($cb);
foreach ($cb as $g => $sgs) {ksort($sgs); foreach ($sgs as $sg => $cods) {ksort($cods); foreach ($cods as $cod => $codb) {
$grid2[$codb]=$grid[$codb];
}}}}


$html="";$cabe=array();$rotura=0; 

$fila=0;
if(count($grid2)>0){
foreach ($grid2 as $ida => $val){$nomb=$noms[$ida];
$re=$rep[$ida];
if(array_key_exists($ida, $rep2)){
$re2=$rep2[$ida];
}else{
$re2=0;	
}
$stock=$stocks[$ida];

if($tip==1){$stock2=$stock;};
if($tip==2){$stock2=$stock-$re2;};	

$stock3=$stock-$re2;

$dr=$re2-$re;

$fila++;


$cdbb=$codis[$ida];
$gp=substr($cdbb,0, 2);
$cog=substr($cdbb,2, 2);
$cdar=substr($cdbb,4);

$gridEX[$fila+1]['A']=$gp;
$gridEX[$fila+1]['B']=$cog;
$gridEX[$fila+1]['C']=$cdar;
$gridEX[$fila+1]['D']=$nomis[$ida];
$gridEX[$fila+1]['E']=$re;
$sumREP=$sumREP+$re;



if($stock3 < 0){$st=" style='background-color:#F8CDD9;'";$rotura=1;$rotis[$fila+1]='#F8CDD9';}else{$st="";};

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
<input type='hidden' id='dr-$fila' value='$dr'>
<input type='hidden' id='idgf-$fila' value='$idagrupacion'>
</td>

";



$NFhtml="


<tr id='%ida%'>

<td style='border-bottom: 1px solid #888888;' ondblclick='ShowDetArt(1,%ida%);'>
<div class='camp_REP_art' id='z1'> %nom% </div>
</td>

<td style='width:28px;border-bottom: 1px solid #888888;'>
<div class='camp_REP_rep' id='rep-%ida%'> </div>
</td>

<td style='width:28px;border-bottom: 1px solid #888888;border-right:2px solid orange;'>
<div class='camp_REP_alm' id='sto-%ida%'> %sto% </div>
<input type='hidden' id='stck-%ida%' value='%sto2%'>
<input type='hidden' id='fl-%fil%' value='%ida%'>
<input type='hidden' id='dr-%fil%' value='%dr%'>
<input type='hidden' id='idgf-%fil%' value='$idagrupacion'>
</td>


";



$count=0;$columna=0;

$gridEX[1]['E']='REP'; 
$colT[]='F';$colT[]='G';$colT[]='H';$colT[]='I';$colT[]='J';$colT[]='K';$colT[]='L';$colT[]='M';
$colT[]='N';$colT[]='O';$colT[]='P';$colT[]='Q';$colT[]='R';$colT[]='S';$colT[]='T';$colT[]='U';$colT[]='V';$colT[]='W';
//if($idagrupacion=='GRID'){$tindm=$tiendas;};
$ctt=0;
foreach ($tiendas as $idt => $nomc) {if(array_key_exists($idt, $tindm)){
		
$cabe[$nomc]= "<div class='cabtab_REP tab_REP_tie'>$nomc</div>";		
$gridEX[1][$colT[$ctt]]=$nomc; 		
		
	$count++;
	$columna++;	
		
			if(array_key_exists($idt, $val)){
			$cant=$val[$idt];$idp=$idpeds[$ida][$idt];	
			}else{
			$cant="";$idp="";	
			}	
			
		if(!$modi){
		$acciones2="";	
		$acciones="
		<div class='camp_REP_tie' id='$idp'>$cant</div>
		";	
			
		}else{
		$acciones="
		<input type='text' onfocus='this.select();' value='$cant' class='camp_REP_tie' id='$fila-$columna' onchange='updtPed(\"$idp\",\"$fila-$columna\")' tabindex='$fila-$columna'>
		<input type='hidden' id='t-$fila-$columna' value='$idt'>
		";
		
		$acciones2="
		<input type='text' onfocus='this.select();' value='' class='camp_REP_tie' id='%fil%-$columna' onchange='updtPed(\"\",\"%fil%-$columna\")' tabindex='%fil%-$columna'>
		<input type='hidden' id='t-%fil%-$columna' value='$idt'>
		";
		
		}
		
	$html .="
	
	<td class='' style='width:24px;border-bottom: 1px solid #888888;'>
	<input type='hidden' value='' id='d-$idp'>
	$acciones
	</td>
	
	
	";	
	
	
	$gridEX[$fila+1][$colT[$ctt]]=$cant; 	
	if(isset($sumav[$colT[$ctt]])){$sumav[$colT[$ctt]]=$sumav[$colT[$ctt]]+$cant;}else{$sumav[$colT[$ctt]]=$sumav[$colT[$ctt]]=$cant;}	
	
	$ctt++;
	
  $NFhtml .="
  
 	<td class='' style='width:24px;border-bottom: 1px solid #888888;'>
	<input type='hidden' value='' id='d-'>
	$acciones2
	</td>
	
	
  
  ";







	
}}


	
}

$gridEX[$fila+2]['E']=$sumREP;
if(count($sumav)>0){
foreach ($sumav as $coli => $value) {
$gridEX[$fila+2][$coli]=$value;
$anchos[$coli]=10;		
}}


}else{
$queryp= "select nombre, estado from agrupedidos where id=$idagrupacion;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$html="";$nagru=$row['nombre'];$estado=$row['estado'];}
	
	
}



if (!$dbnivel->close()){die($dbnivel->error());};

$cabe2="";
if(count($cabe)>0){foreach($cabe as $nc => $cod){$cabe2.=$cod;};};

if(!$todas){$valores['cabe']=$cabe2;};



$anchos['A']=10;
$anchos['B']=10;
$anchos['C']=10;
$anchos['D']=30;
$anchos['E']=10;



$valores['cabe']=$cabe2;
$valores['roto']=$rotura;
$valores['html']=$html;
$valores['nagru']=$nagru;
$valores['estado']=$estado;
$valores['maxfil']=$fila;
$valores['new_fil']=$NFhtml;


if(count($rotis)>0){foreach ($rotis as $fil => $cgr) {
$crang["A$fil:" . $coli . $fil]=$cgr;	
}}else{
$crang=array();	
}

$BTrang['A1:' . $coli . ($fila+2)]=1;

//echo json_encode($valores);

print_r($gridEX);

$_SESSION['angle']=array();
$_SESSION['cgd'] = array(); 
$_SESSION['grid'] = array(); 
$_SESSION['anchos'] = $anchos;
$_SESSION['align'] = array();
$_SESSION['crang']=$crang;
$_SESSION['Mrang']=array();
$_SESSION['BTrang']=$BTrang;
$_SESSION['paginas']=array();
$_SESSION['format']=array();
$_SESSION['nomfil']="PedidosGRID";
$_SESSION['BOLDrang']=array();

$_SESSION['grid'] = $gridEX; 

?>



