<?php
session_start();
set_time_limit(0);


require_once("basics.php");
require_once("../db.php");
require_once("../variables.php");

$debug=1;




foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$fini="2013-08-01";
$ffin="2013-08-15";



$peds="";$cods="";$codigos=array();$vendidos=array();$cord="";


foreach ($tiendas as $idt => $nom) {
$vendidos[$idt]=array();
$stocks[$idt]=array();	
}



if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select id from agrupedidos where (estado='T' OR estado='E' OR estado='F') AND (fecha >= '$fini' AND fecha <= '$ffin');";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$peds .=$row['id'] . ",";};
$peds=substr($peds, 0,-1);


$queryp= "select (select codbarras from articulos where id=id_articulo) as codbarras, 
(select refprov from articulos where id=id_articulo) as refprov, 
id_tienda, sum(cantidad) as cant from pedidos where agrupar in ($peds) group by id_articulo, id_tienda;";
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

foreach ($tiends as $idt => $value) {
	$queryp= "select cod, stock from stocklocal_$idt where cod IN ($cods);";
	$dbBAK->query($queryp); if($debug){echo "$queryp \n\n";};
	while ($row = $dbBAK->fetchassoc()){
	$cd=$row['cod']; $cant=$row['stock']; 
	$stocks[$idt][$cd]=$cant;
	}
}


if (!$dbBAK->close()){die($dbBAK->error());};



ksort($cord); foreach ($cord as $gu => $subs) {ksort($subs); foreach ($subs as $sb => $ccs)	{ksort($ccs); foreach ($ccs as $cd => $codbar) {
$cdg[$codbar]=1;
}}}



$gridD=array();
$fila=0;

$flini=$fila+1;
foreach ($cdg as $codbar => $point) {$fila++;
	


$col=1;
$grid[$fila][$colu[$col]]="REFERENCIAS";$col++; $iniC=$col;
$grid[$fila][$colu[$col]]="TOT";$col++; 
foreach ($tiendas as $idt => $nom) {$grid[$fila][$colu[$col]]=$nom;$col++;};
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
		}}
		$tcant=$tcant + ($cant*1);
		$grid[$fila][$colu[$col]]=$cant;$col++;
		};
		$grid[$fila][$colu[$dtot]]=$tcant;
		$crang['A' . $fila . ':' . $colu[$col] . $fila]='CCCCCC'; 		
		
		$fila++;
		

$col=1;
$grid[$fila][$colu[$col]]="VENDIDOS";$col++;
$dtot=$col; $tven=0;  $col++;
foreach ($tiendas as $idt => $nom) {
	$ven="";
	if(array_key_exists($codbar,$vendidos[$idt])){
	$ven=$vendidos[$idt][$codbar]['c'];	
	}	
	$tven=$tven + ($ven*1);
	$grid[$fila][$colu[$col]]=$ven;$col++;
	};
	$grid[$fila][$colu[$dtot]]=$tven;
	$crang['A' . $fila . ':' . $colu[$col] . $fila]='FFFF66'; 	
	$fila++;	



$col=1;
$grid[$fila][$colu[$col]]="EN TIENDA";$col++;
$dtot=$col; $tsto=0;  $col++;
foreach ($tiendas as $idt => $nom) {
	$sto="";
		if(array_key_exists($codbar,$stocks[$idt])){
		$sto=$stocks[$idt][$codbar];	
	}
	$tsto=$tsto + ($sto*1);
	$grid[$fila][$colu[$col]]=$sto;$col++;
	};
	$grid[$fila][$colu[$dtot]]=$tsto;
	$crang['A' . $fila . ':' . $colu[$col] . $fila]='CCFF99'; 
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

	$grid[$fila][$colu[$col]]=$por;$col++;
	
	$color='99FF33';if($por <= 75){$color='FFFF66';};if($por <= 50){$color='FF6666';};if($por <= 25){$color='FF6666';}; 	
	$crang[$colu[$col]. $fila]=$color;
    }

	$porT=round(($tcant/100)*$tven,2);
	$grid[$fila][$colu[$dtot]]=$porT;
	$color='99FF33';if($porT <= 75){$porT='FFFF66';};if($porT <= 50){$porT='FF6666';};if($porT <= 25){$color='FF6666';}; 	
	$crang[$colu[$dtot]. $fila]=$color;
	 
	$fila++;






}
$flfin=$fila;


$anchos['A']=30;
$anchos['B']=7;
for ($i=3; $i <= count($tiendas)+3 ; $i++) {$anchos[$colu[$i]]=7;};


$align['A' . $flini . ':' . 'A' . $flfin]='C';
$align['B' . $flini . ':' . 'B' . $flfin]='C';

$_SESSION['grid'] = $grid;
$_SESSION['anchos'] = $anchos;
$_SESSION['align'] = $align;
$_SESSION['crang']=$crang;

//$_SESSION['vendidos'] = $vendidos;
//$_SESSION['stocks'] = $stocks;
//$_SESSION['tiendas'] = $tiendas;
//if($debug==1){print_r($_SESSION);};

?>