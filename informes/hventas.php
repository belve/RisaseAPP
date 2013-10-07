<?php
session_start();
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("basics.php");
require_once("../db.php");
require_once("../variables.php");

$debug=0;



$options="";
$id_proveedor="";$id_grupo="";$id_subgrupo="";$id_color="";$codigo="";$pvp="";$desde="";$hasta="";$temporada="";$hago="";
$yalistados="";
$detalles="";
$comentarios="";
$ord=1;
$tab=1;
$arts=array();
$vals=array();
$fijos	=array();
$pvps= array();
$tiends=array();
$totcod=array();
$codVEND=array();
$codPOR=array();

$fini="";
$ffin="";

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$fdesde=$fini; $fhasta=$ffin;
$fini=substr($fini, 6,4) . "-" . substr($fini, 3,2) . "-" . substr($fini, 0,2);
$ffin=substr($ffin, 6,4) . "-" . substr($ffin, 3,2) . "-" . substr($ffin, 0,2);


$peds="";$cods="";$codigos=array();$vendidos=array();$cord=array();

if (!$dbnivel->open()){die($dbnivel->error());};
$nprov="";
if($id_proveedor){
$queryp= "select nomcorto from proveedores where id=$id_proveedor;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nprov=$row['nomcorto'];};
}


$ngrupo="";
if($id_grupo){
$queryp= "select nombre from grupos where id=$id_grupo;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$ngrupo=$row['nombre'];};
}
$nsgrupo="";
if($id_subgrupo){
$queryp= "select nombre from subgrupos where id=$id_subgrupo;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nsgrupo=$row['nombre'];};
}

$ncolor="";
if($id_color){
$queryp= "select nombre from colores where id=$id_color;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$ncolor=$row['nombre'];};
}



foreach ($tiendas as $idt => $nom) {
$vendidos[$idt]=array();
$stocks[$idt]=array();	
}







require_once("../functions/listador.php");

$codigosIN="";
if($options){
$queryp= "select id from articulos where $options;";
}else{
$queryp= "select id from articulos where congelado=0;";
}	
		
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$id_articulo=$row['id'];
$codigosIN .=$id_articulo . ",";
}
$codigosIN=substr($codigosIN, 0,-1);
$codigosIN="AND id_articulo IN ($codigosIN)";




$agrupaciones="";
$queryp= "select distinct agrupar from pedidos where ((fecha >= '$fini' AND fecha <= '$ffin') OR tip=1) $codigosIN ;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$agrupaciones .=$row['agrupar'] . ",";};
$agrupaciones=substr($agrupaciones, 0,-1);


$queryp= "select id from agrupedidos where id IN ($agrupaciones) AND (estado='T' OR estado='E' OR estado='F') AND ((fecha >= '$fini' AND fecha <= '$ffin') OR tip=1);";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$peds .=$row['id'] . ",";};


$peds=substr($peds, 0,-1);


$queryp= "select (select codbarras from articulos where id=id_articulo) as codbarras, 
(select refprov from articulos where id=id_articulo) as refprov, 
id_tienda, sum(cantidad) as cant from pedidos where agrupar in ($peds) $codigosIN group by id_articulo, id_tienda;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};$enviados=array();
while ($row = $dbnivel->fetchassoc()){
	
$cd=$row['codbarras']; $idt=$row['id_tienda']; $cant=$row['cant']; $refprov=$row['refprov'];


if(!array_key_exists($cd, $codigos)){
$codigos[$cd]="$cd / $refprov";
$g=substr($cd,0,1);$sg=substr($cd,1,1);$c=substr($cd,4);
$cord[$g][$sg][$c]=$cd;
$cods .=$cd . ","; 
$totcod[$cd]=1;
}

$tiends[$idt]=1;
$enviados[$cd][$idt]=$cant;
}


############ aqui debo sumar lo enviado en fijarstock
$queryp= "select (select codbarras from articulos where id=id_articulo) as codbarras, 
id_tienda, sum(suma) as cant from fij_stock where bd=2 AND (fecha >= '$fini' AND fecha <= '$ffin') $codigosIN group by id_articulo, id_tienda;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$cd=$row['codbarras']; $idt=$row['id_tienda']; $cant=$row['cant']; 
if(array_key_exists($cd, $enviados)){
if(array_key_exists($idt, $enviados[$cd])){	
$enviados[$cd][$idt]=$enviados[$cd][$idt]+$cant;	

}else{$enviados[$cd][$idt]=$cant;	}
}else{$enviados[$cd][$idt]=$cant;	}
}
########################################################




$cods=substr($cods, 0,-1);

$codv=array();
$queryp= "select id_articulo, id_tienda, sum(cantidad) as cant, sum(importe * cantidad) as imp, importe from ticket_det where (fecha >= '$fini' AND fecha <= '$ffin')
 AND id_articulo IN ($cods) group by id_articulo, id_tienda;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
$cods2="";
while ($row = $dbnivel->fetchassoc()){
$cd=$row['id_articulo']; $idt=$row['id_tienda']; $cant=$row['cant']; $imp=$row['imp'];

			$vendidos[$idt][$cd]['c']=$cant;
			$vendidos[$idt][$cd]['i']=$imp;


}
$cods2=substr($cods2, 0,-1);


if (!$dbnivel->close()){die($dbnivel->error());};


$dbBAK=new DB('192.168.1.11','edu','admin','tpv_backup');
if (!$dbBAK->open()){die($dbBAK->error());};

if(count($tiends)>0){
foreach ($tiends as $idt => $value) {
	$queryp= "select cod, stock from stocklocal_$idt where cod IN ($cods);";
	$dbBAK->query($queryp); if($debug){echo "$queryp \n\n";};
	while ($row = $dbBAK->fetchassoc()){
	$cd=$row['cod']; $cant=$row['stock']; 
	$stocks[$idt][$cd]=$cant;
	}
}}


if (!$dbBAK->close()){die($dbBAK->error());};


$sumc=array();
foreach ($enviados as $cdba => $value) { foreach ($value as $idt => $cant){
if(array_key_exists($cdba, $sumc)){$sumc[$cdba]=$sumc[$cdba] + $cant;}else{$sumc[$cdba]=$cant;};
}}

$sume=array();
foreach ($vendidos as $idt => $value) {  foreach ($value as $cdba => $cant){
if(array_key_exists($cdba, $sume)){$sume[$cdba]=$sume[$cdba] + $cant['c'];}else{$sume[$cdba]=$cant['c'];};
}}


$sumST=array();
foreach ($stocks as $idt => $value) {  foreach ($value as $cdba => $cant){
if(array_key_exists($cdba, $sumST)){$sumST[$cdba]=$sumST[$cdba] + $cant;}else{$sumST[$cdba]=$cant;};
}}





foreach ($totcod as $cdba => $point) {
$cant=0;$evn=0;$stc=0;
if(array_key_exists($cdba, $sumc)){$cant=$sumc[$cdba];};	
if(array_key_exists($cdba, $sume)){$evn=$sume[$cdba];};
if(array_key_exists($cdba, $sumST)){$stc=$sumST[$cdba];};
	
if($cant>0){$por=round(($evn/$cant*100),2);  $codPOR[$cdba]=$por;}else{ $codPOR[$cdba]=0;};	
$codVEND[$cdba]=$evn;
$codSTOK[$cdba]=$stc;
}



if($act==1){
$cdg=array();
if(count($cord)>0){
if($actO=='A'){ksort($cord);}else{krsort($cord);} 
foreach ($cord as $gu => $subs) {
	if($actO=='A'){ksort($subs);}else{krsort($subs);} foreach ($subs as $sb => $ccs)	{
		if($actO=='A'){ksort($ccs);}else{krsort($ccs);} foreach ($ccs as $cd => $codbar) {
$cdg[$codbar]=1;
}}}}}


if($act==2){
$cdg=array();
if(count($codPOR)>0){
if($actO=='A'){asort($codPOR);}else{arsort($codPOR);}
foreach ($codPOR as $codbar => $portc){
$cdg[$codbar]=1;	
}}}


if($act==3){
$cdg=array();
if(count($codVEND)>0){
if($actO=='A'){asort($codVEND);}else{arsort($codVEND);}
foreach ($codVEND as $codbar => $portc){
$cdg[$codbar]=1;	
}}}



if($act==4){
$cdg=array();
if(count($codSTOK)>0){
if($actO=='A'){asort($codSTOK);}else{arsort($codSTOK);}
foreach ($codSTOK as $codbar => $portc){
$cdg[$codbar]=1;	
}}}




$totales=array();
foreach ($tiendas as $idt => $nom) {$totales[$idt]['c']=0;$totales[$idt]['v']=0;$totales[$idt]['s']=0;};
$gridD=array();
$fila=7;

$flini=$fila+1;

if(count($cdg)>0){
foreach ($cdg as $codbar => $point) {$fila++;
	


$col=1;
$grid[$fila][$colu[$col]]="REFERENCIAS";$col++; $iniC=$col;
$grid[$fila][$colu[$col]]="TOT";$col++; 
foreach ($tiendas as $idt => $nom) {
	$grid[$fila][$colu[$col]]=$nom;$col++;};
$align[$colu[$iniC] . $fila . ':' . $colu[$col] . $fila]='C'; 

$fila++;


$col=1;
$grid[$fila][$colu[$col]]=$codigos[$codbar]; $col++;
$dtot=$col; $tcant=0;  $col++;
foreach ($tiendas as $idt => $nom) {
		$cant="";
		if(array_key_exists($codbar,$enviados)){
		if(array_key_exists($idt, $enviados[$codbar])){
		$cant=$enviados[$codbar][$idt];
		if(array_key_exists('c',$totales[$idt])){$totales[$idt]['c']=$totales[$idt]['c']+$cant;}else{$totales[$idt]['c']=$cant;};		
		}}
		$tcant=$tcant + ($cant*1);
		$grid[$fila][$colu[$col]]=$cant;$col++;
		};
		$grid[$fila][$colu[$dtot]]=$tcant;
		$crang['A' . $fila . ':' . $colu[$col-1] . $fila]='CCCCCC'; 		
		
		$fila++;
		

$col=1;
$grid[$fila][$colu[$col]]="VENDIDOS";$col++;
$dtot=$col; $tven=0;  $col++;
foreach ($tiendas as $idt => $nom) {
	$ven="";
	if(array_key_exists($codbar,$vendidos[$idt])){
	$ven=$vendidos[$idt][$codbar]['c'];	
	if(array_key_exists('v',$totales[$idt])){$totales[$idt]['v']=$totales[$idt]['v']+$ven;}else{$totales[$idt]['v']=$ven;};
	}
	
	$tven=$tven + ($ven*1);
	$grid[$fila][$colu[$col]]=$ven;$col++;
	};
	$grid[$fila][$colu[$dtot]]=$tven;
	$crang['A' . $fila . ':' . $colu[$col-1] . $fila]='FFFF66'; 	
	$fila++;	



$col=1;
$grid[$fila][$colu[$col]]="EN TIENDA";$col++;
$dtot=$col; $tsto=0;  $col++;
foreach ($tiendas as $idt => $nom) {
	$sto="";
		if(array_key_exists($codbar,$stocks[$idt])){
		$sto=$stocks[$idt][$codbar];
		if(array_key_exists('s',$totales[$idt])){$totales[$idt]['s']=$totales[$idt]['s']+$sto;}else{$totales[$idt]['s']=$sto;};		
	}
	$tsto=$tsto + ($sto*1);
	$grid[$fila][$colu[$col]]=$sto;$col++;
	};
	$grid[$fila][$colu[$dtot]]=$tsto;
	$crang['A' . $fila . ':' . $colu[$col-1] . $fila]='CCFF99'; 
	$fila++;



$col=1;
$grid[$fila][$colu[$col]]="PORCENTAJE ENV/VEND";$col++;
$dtot=$col; $tsto=0;  $col++;
foreach ($tiendas as $idt => $nom) {
	
	$cant=0;
	if(array_key_exists($codbar,$enviados)){
		if(array_key_exists($idt, $enviados[$codbar])){
		$cant=$enviados[$codbar][$idt];	
	}}
	
	$ven=0;
	if(array_key_exists($codbar,$vendidos[$idt])){
	$ven=$vendidos[$idt][$codbar]['c'];	
	}
	if($cant>0){$por=round(($ven/$cant*100),2);}else{$por="";};

	$grid[$fila][$colu[$col]]=$por;
	if($por>75){$color='99FF33';};if($por <= 75){$color='FFFF66';};if($por <= 50){$color='FFCC66';};if($por <= 25){$color='FF6666';}; 	
	if(!is_numeric($por)){$color='FFFFFF';};
	$crang[$colu[$col]. $fila]=$color; $col++;
    }

	
	if($tcant>0){$porT=round(($tven/$tcant*100),2);}else{$porT="";};
	
	$grid[$fila][$colu[$dtot]]=$porT;
	if($porT>75){$color='99FF33';};if($porT <= 75){$color='FFFF66';};if($porT <= 50){$color='FFCC66';};if($porT <= 25){$color='FF6666';}; 	
	if(!is_numeric($porT)){$color='FFFFFF';};
	$crang[$colu[$dtot]. $fila]=$color;
	 
	$fila++;






}}

$fila=$fila+5;
$col=3;

$grid[$fila]['A']='SUMAS TOTALES';$grid[$fila]['B']='TOT'; 
$grid[$fila+1]['A']='RECIBIDOS'; 
$grid[$fila+2]['A']='VENDIDOS'; 
$grid[$fila+3]['A']='ENTIENDA'; 
$grid[$fila+4]['A']='PORCENTAJE';

$CT=0;$VT=0;$ST=0;
foreach ($tiendas as $idt => $nom) {

$grid[$fila][$colu[$col]]=$nom; 
$grid[$fila+1][$colu[$col]]=$totales[$idt]['c']; $CT=$CT+$totales[$idt]['c'];
$grid[$fila+2][$colu[$col]]=$totales[$idt]['v']; $VT=$VT+$totales[$idt]['v'];
$grid[$fila+3][$colu[$col]]=$totales[$idt]['s']; $ST=$ST+$totales[$idt]['s'];



if($totales[$idt]['c']>0){$por=round(($totales[$idt]['v']/$totales[$idt]['c']*100),2);}else{$por="";};


$grid[$fila+4][$colu[$col]]=$por;
if($por>75){$color='99FF33';};if($por <= 75){$color='FFFF66';};if($por <= 50){$color='FFCC66';};if($por <= 25){$color='FF6666';}; 	
if(!is_numeric($por)){$color='FFFFFF';};
$crang[$colu[$col] . ($fila+4)]=$color;


$col++;	
}

$grid[$fila+1]['B']=$CT;
$grid[$fila+2]['B']=$VT;
$grid[$fila+3]['B']=$ST;

if($CT>0){$porT=round(($VT/$CT*100),2);}else{$porT="";};
if($porT>75){$color='99FF33';};if($porT <= 75){$color='FFFF66';};if($porT <= 50){$color='FFCC66';};if($porT <= 25){$color='FF6666';}; 	
if(!is_numeric($porT)){$color='FFFFFF';};
$crang['B' . ($fila+4)]=$color;
$grid[$fila+4]['B']=$porT;

	

$crang['A' . ($fila+1) . ':' . $colu[$col-1] . ($fila+1)]='CCCCCC'; 
$crang['A' . ($fila+2) . ':' . $colu[$col-1] . ($fila+2)]='FFFF66'; 
$crang['A' . ($fila+3) . ':' . $colu[$col-1] . ($fila+3)]='CCFF99'; 
$align['C' . ($fila) . ':' . $colu[$col-1] . ($fila)]='C'; 


$fila=$fila+4;



$flfin=$fila;

$anchos['A']=50;
$anchos['B']=7;

for ($i=3; $i <= count($tiendas)+3 ; $i++) {$anchos[$colu[$i]]=7;};


$align['A' . $flini . ':' . 'A' . $flfin]='C';
$align['B' . $flini . ':' . 'B' . $flfin]='C';


$hoy=date('d') . "/" . date('m') . "/" . date('Y');
$grid[1]['A']="FECHA IMPRESION: $hoy";
$grid[1]['B']="GRUPO: $ngrupo";	$Mrang['B1:F1']=1;
$grid[1]['G']="SUBGRUPO: $nsgrupo"; $Mrang['G1:K1']=1;
$grid[1]['L']="COLOR: $ncolor"; 	$Mrang['L1:O1']=1;
$grid[1]['P']="PRECIO: $pvp";	$Mrang['P1:S1']=1;



$grid[2]['A']="PROVEEDOR: $nprov";
$grid[2]['B']="DESDE: $desde";	$Mrang['B2:F2']=1;
$grid[2]['G']="HASTA: $hasta";	$Mrang['G2:K2']=1;
$grid[2]['L']="TEMPORADA: $temporada";$Mrang['L2:O2']=1;

$grid[3]['B']="INTERVALO DE FECHAS                       DESDE: $fdesde                                HASTA: $fhasta "; $Mrang['B3:O3']=1;
 
$BTrang['A1:S1']=1;
$BTrang['A2:O2']=1;
$BTrang['B3:O3']=1;

$_SESSION['grid'] = $grid; 
$_SESSION['anchos'] = $anchos;
$_SESSION['align'] = $align;
$_SESSION['crang']=$crang;
$_SESSION['Mrang']=$Mrang;
$_SESSION['BTrang']=$BTrang;

$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang);
echo json_encode($res);
//echo "rows: " . (count($grid)+count($anchos)+count($align)+count($crang));

//$_SESSION['vendidos'] = $vendidos;
//$_SESSION['stocks'] = $stocks;
//$_SESSION['tiendas'] = $tiendas;
//if($debug==1){print_r($_SESSION);};

?>