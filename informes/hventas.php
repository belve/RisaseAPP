<?php
session_start();
set_time_limit(0);


require_once("basics.php");
require_once("../db.php");
require_once("../variables.php");

$debug=1;



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

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$fini="2013-08-01";
$ffin="2013-08-05";



$peds="";$cods="";$codigos=array();$vendidos=array();$cord=array();


foreach ($tiendas as $idt => $nom) {
$vendidos[$idt]=array();
$stocks[$idt]=array();	
}



if (!$dbnivel->open()){die($dbnivel->error());};



require_once("../functions/listador.php");

$codigos="";
$queryp= "select id from articulos where $options;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$id_articulo=$row['id'];
$codigos .=$id_articulo . ",";
}
$codigos=substr($codigos, 0,-1);


$agrupaciones="";
$queryp= "select agrupar from pedidos where id_articulo IN ($codigos) AND (fecha >= '$fini' AND fecha <= '$ffin') ;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$agrupaciones .=$row['agrupar'] . ",";};
$agrupaciones=substr($agrupaciones, 0,-1);


$queryp= "select id from agrupedidos where id IN ($agrupaciones) AND (estado='T' OR estado='E' OR estado='F') AND (fecha >= '$fini' AND fecha <= '$ffin');";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$peds .=$row['id'] . ",";};
$peds=substr($peds, 0,-1);


$queryp= "select (select codbarras from articulos where id=id_articulo) as codbarras, 
(select refprov from articulos where id=id_articulo) as refprov, 
id_tienda, sum(cantidad) as cant from pedidos where agrupar in ($peds) AND id_articulo IN ($codigos) group by id_articulo, id_tienda;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
	
$cd=$row['codbarras']; $idt=$row['id_tienda']; $cant=$row['cant']; $refprov=$row['refprov'];
$cods .=$cd . ","; 

if(!array_key_exists($cd, $codigos)){
$tiends[$idt]=1;	
$codigos[$cd]="$cd / $refprov";
$g=substr($cd,0,1);$sg=substr($cd,1,1);$c=substr($cd,4);
$cord[$g][$sg][$c]=$cd;
}


$enviados[$cd][$idt]=$cant;
}

$cods=substr($cods, 0,-1);


$queryp= "select id_articulo, id_tienda, sum(cantidad) as cant, sum(importe * cantidad) as imp, importe from ticket_det where (fecha >= '$fini' AND fecha <= '$ffin')
 AND id_articulo IN ($cods) group by id_articulo, id_tienda;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$cd=$row['id_articulo']; $idt=$row['id_tienda']; $cant=$row['cant']; $imp=$row['imp'];
$cods .=$cd . ",";
$vendidos[$idt][$cd]['c']=$cant;
$vendidos[$idt][$cd]['i']=$imp;

}



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

$cdg=array();
if(count($cord)>0){
ksort($cord); foreach ($cord as $gu => $subs) {ksort($subs); foreach ($subs as $sb => $ccs)	{ksort($ccs); foreach ($ccs as $cd => $codbar) {
$cdg[$codbar]=1;
}}}}

$totales=array();
foreach ($tiendas as $idt => $nom) {$totales[$idt]['c']=0;$totales[$idt]['v']=0;$totales[$idt]['s']=0;};
$gridD=array();
$fila=6;

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

	$por=round(($cant/100)*$ven,2);

	$grid[$fila][$colu[$col]]=$por;
	$color='99FF33';if($por <= 75){$color='FFFF66';};if($por <= 50){$color='FF6666';};if($por <= 25){$color='FF6666';}; 	
	$crang[$colu[$col]. $fila]=$color; $col++;
    }

	$porT=round(($tcant/100)*$tven,2);
	$grid[$fila][$colu[$dtot]]=$porT;
	$color='99FF33';if($porT <= 75){$color='FFFF66';};if($porT <= 50){$color='FF6666';};if($porT <= 25){$color='FF6666';}; 	
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

$por=round(($totales[$idt]['c']/100)*$totales[$idt]['v'],2);

$grid[$fila+4][$colu[$col]]=$por;
$color='99FF33';if($por <= 75){$color='FFFF66';};if($por <= 50){$color='FF6666';};if($por <= 25){$color='FF6666';}; 	

$crang[$colu[$col] . ($fila+4)]=$color;


$col++;	
}

$grid[$fila+1]['B']=$CT;
$grid[$fila+2]['B']=$VT;
$grid[$fila+3]['B']=$ST;
$grid[$fila+4]['B']=round(($CT/100)*$VT,2);



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



$grid[1]['A']='FECHA IMPRESION: ';
$grid[1]['B']='GRUPO: ';	$Mrang['B1:F1']=1;
$grid[1]['G']='SUBGRUPO: '; $Mrang['G1:K1']=1;
$grid[1]['L']='COLOR: '; 	$Mrang['L1:O1']=1;
$grid[1]['P']='PRECIO: ';	$Mrang['P1:S1']=1;



$grid[2]['A']='PROVEEDOR: ';
$grid[2]['B']='DESDE: ';	$Mrang['B2:F2']=1;
$grid[2]['G']='HASTA: ';	$Mrang['G2:K2']=1;
$grid[2]['L']='TEMPORADA: ';$Mrang['L2:O2']=1;

$grid[3]['B']='INTERVALO DE FECHAS                       DESDE: 21/05/2008                                HASTA: 15/08/2009 '; $Mrang['B3:O3']=1;
 
$BTrang['A1:S1']=1;
$BTrang['A2:O2']=1;
$BTrang['B3:O3']=1;

$_SESSION['grid'] = $grid; 
$_SESSION['anchos'] = $anchos;
$_SESSION['align'] = $align;
$_SESSION['crang']=$crang;
$_SESSION['Mrang']=$Mrang;
$_SESSION['BTrang']=$BTrang;

echo "rows: " . (count($grid)+count($anchos)+count($align)+count($crang));

//$_SESSION['vendidos'] = $vendidos;
//$_SESSION['stocks'] = $stocks;
//$_SESSION['tiendas'] = $tiendas;
//if($debug==1){print_r($_SESSION);};

?>