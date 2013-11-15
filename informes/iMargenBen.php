<?php
session_start();
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("basics.php");
require_once("../db.php");
require_once("../variables.php");

$debug=0;




$frqcia="";
$options=""; $cong=0;
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
$PC=array();
$VV=array();
$BE=array();$datos=array();
$paginas=array();$grid=array();$cord=array();$datos=array();
$fini="";
$ffin="";$mes="";
$format=array(); $BOLDrang=array(); $tipo=""; $temp="";$ccn=0;$total=0;$p=0;
$ttss="";$rot=0; $dev=0; 
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$ttss=substr($ttss, 0,-1);$emps=array();
$frqcia=1;

$fini=substr($fini, 6,4) . "-" . substr($fini, 3,2) . "-" . substr($fini, 0,2);
$ffin=substr($ffin, 6,4) . "-" . substr($ffin, 3,2) . "-" . substr($ffin, 0,2);





if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id, nombre from grupos;";
$dbnivel->query($queryp); 
if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$nomgru[$row['id']]=$row['nombre'];};


$queryp= "
select codbarras, pvp, preciocosto from articulos;";
$dbnivel->query($queryp);
if($debug){echo "$queryp \n\n";};$piez=array();
while ($row = $dbnivel->fetchassoc()){
$pvps[$row['codbarras']]=$row['pvp'];	
$pcos[$row['codbarras']]=$row['preciocosto'];
}


$queryp= "
select id_tienda, (select pvp from articulos where id=id_articulo) as pvp, 
(select preciocosto from articulos where id=id_articulo) as pcos,  
(select codbarras from articulos where id=id_articulo) as SG , sum(cantidad) as cant 
from pedidos 
where (estado='T' OR estado='E' OR estado='F') AND 
(fecha >= '$fini' AND fecha <= '$ffin') 
AND id_tienda IN ($ttss) 
AND id_articulo NOT IN (10009999,20009999,30009999,40009999,50009999,60009999,70009999,80009999,90009999) 
group by id_tienda, id_articulo; ";
$dbnivel->query($queryp);
if($debug){echo "$queryp \n\n";};$piez=array();

while ($row = $dbnivel->fetchassoc()){
$idt=$row['id_tienda'];	
	
$piez[$idt][$row['SG']]['pvp']=$row['cant']*$row['pvp'];
$piez[$idt][$row['SG']]['pcos']=$row['cant']*$row['pcos'];

}



############ aqui debo sumar lo enviado en fijarstock
$queryp= "select id_tienda, (select pvp from articulos where id=id_articulo) as pvp, (select preciocosto from articulos where id=id_articulo) as pcos, (select codbarras from articulos where id=id_articulo) as codbarras, 
sum(suma) as cant from fij_stock where bd=2 AND (fecha >= '$fini' AND fecha <= '$ffin')  AND id_tienda IN ($ttss) 
AND id_articulo NOT IN (10009999,20009999,30009999,40009999,50009999,60009999,70009999,80009999,90009999) 
group by id_tienda, id_articulo;";
$dbnivel->query($queryp); 
if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$idt=$row['id_tienda'];			

if(!array_key_exists($idt, $piez)){$piez[$idt]=array();};
	
if(array_key_exists($row['codbarras'], $piez[$idt])){
	$piez[$idt][$row['codbarras']]['pvp']=$piez[$idt][$row['codbarras']]['pvp']+($row['cant']*$row['pvp']);
	$piez[$idt][$row['codbarras']]['pcos']=$piez[$idt][$row['codbarras']]['pcos']+($row['cant']*$row['pcos']);
	}else{
	$piez[$idt][$row['codbarras']]['pvp']=$row['cant']*$row['pvp'];
	$piez[$idt][$row['codbarras']]['pcos']=$row['cant']*$row['pcos'];
	}
}

if (!$dbnivel->close()){die($dbnivel->error());};







if($risase){$db='risasa';}else{$db='risase';};
$dbn=new DB('192.168.1.11','edu','admin',$db);

if (!$dbn->open()){die($dbn->error());};
$queryp= "select id_tienda, id_articulo, sum(cantidad) as qty, importe from ticket_det 
where fecha >= '$fini' AND fecha <= '$ffin' AND id_tienda IN ($ttss) 
AND id_articulo NOT IN (10009999,20009999,30009999,40009999,50009999,60009999,70009999,80009999,90009999) 
group by id_tienda, id_articulo; ";	
$dbn->query($queryp);

if($debug){echo "$queryp \n\n";};
echo $dbn->error();

while ($row = $dbn->fetchassoc()){
$cd=$row['id_articulo'];
$idt=$row['id_tienda'];			
	

$vend[$idt][$cd]['pvp']=$row['qty'] * $row['importe'];
$vend[$idt][$cd]['pcos']=$row['qty'] * $pcos[$cd];
$vend[$idt][$cd]['piez']=$row['qty'];


}
if (!$dbn->close()){die($dbn->error());};

$resultE=array();
$resultV=array();
$tenv=array();
$tven=array();

foreach ($piez as $idt => $piez2) { foreach ($piez2 as $cb => $dat) {
	
	$gr=substr($cb,0,2);
	
	if(!array_key_exists($idt, $resultE)){$resultE[$idt]=array();};
	
	if(array_key_exists($gr, $resultE[$idt])){
	$resultE[$idt][$gr]['pvp']=$resultE[$idt][$gr]['pvp']+$dat['pvp'];
	$resultE[$idt][$gr]['pcos']=$resultE[$idt][$gr]['pcos']+$dat['pcos'];	
	}else{
	$resultE[$idt][$gr]['pvp']=$dat['pvp'];	
	$resultE[$idt][$gr]['pcos']=$dat['pcos'];		
	}

if(!array_key_exists($idt, $tenv)){$tenv[$idt]=0;};		
$tenv[$idt]=$tenv[$idt]+$dat['pvp'];		
}}




foreach ($vend as $idt => $vend2) { foreach ($vend2 as $cb => $dat){
	$gr=substr($cb,0,2);
	
	if(!array_key_exists($idt, $resultV)){$resultV[$idt]=array();};
	
	if(!array_key_exists($idt, $resultE)){$resultE[$idt]=array();};
	if(!array_key_exists($gr, $resultE[$idt])){
	$resultE[$idt][$gr]['pvp']=0;	
	$resultE[$idt][$gr]['pcos']=0;	
	}
	
	if(array_key_exists($gr, $resultV[$idt])){
	$resultV[$idt][$gr]['pvp']=$resultV[$idt][$gr]['pvp']+$dat['pvp'];
	$resultV[$idt][$gr]['pcos']=$resultV[$idt][$gr]['pcos']+$dat['pcos'];	
	$resultV[$idt][$gr]['piez']=$resultV[$idt][$gr]['piez']+$dat['piez'];	
	}else{
	$resultV[$idt][$gr]['pvp']=$dat['pvp'];	
	$resultV[$idt][$gr]['pcos']=$dat['pcos'];
	$resultV[$idt][$gr]['piez']=$dat['piez'];			
	}
		

if(!array_key_exists($idt, $tven)){$tven[$idt]=0;};		
$tven[$idt]=$tven[$idt]+$dat['pcos'];
}}






//print_r($resultV);

$idfil=0;$sumMGB=array();
foreach ($resultE as $idt => $datos) {ksort($datos); foreach ($datos as $gr => $dat){$idfil++;
if(!array_key_exists($idt, $sumMGB)){$sumMGB[$idt]=0;};


$datt[$idt][$gr]['idfil']=$idfil;

### Mercancía Enviada:	
$ME=$dat['pcos'];	
$datt[$idt][$gr]['ME']=$ME;

### Mercancía Vendida:	
if(array_key_exists($gr, $resultV[$idt])){$MV=$resultV[$idt][$gr]['pcos'];}else{$MV=0;};	
$datt[$idt][$gr]['MV']=$MV;

########   % Ventas: Es la Mercancía Vendida de ese subgrupo/Suma total de la Mercancía Vendida de todos los grupos (total vendido), en porcentual. 	
$totv=$tven[$idt];
if($totv>0){$pV=$MV/$totv*100;}else{$pV="";}
$datt[$idt][$gr]['pV']=$pV;	
	
###### Diferencia: Es el % de la Mercancía Vendida de ese subgrupo / Mercancía Enviada de ese subgrupo.	
if($ME>0){$DF=($ME-$MV)/$ME*100;}else{$DF="";};	
$datt[$idt][$gr]['DF']=$DF;		

######### Diferencia €: Sólo se debe calcular si la columna Diferencia es un % positivo, vamos si se envió más mercancía de la que se vendió. Es la diferencia entre la Mercancía Vendida - Mercancía Enviada.
if($DF>=0){$DE=$MV-$ME;}else{$DE="";};
$datt[$idt][$gr]['DE']=$DE;	

###### Mercancía Vendida PVP: Igual que la 1ª columna pero en vez de multiplicar por costo, se multiplica por precio de venta.
if(array_key_exists($gr, $resultV[$idt])){$MVpvp=$resultV[$idt][$gr]['pvp'];}else{$MVpvp=0;};
$datt[$idt][$gr]['MVpvp']=$MVpvp;

#####  Margen Bº: Mercancía Vendida PVP-Mercancía Enviada (6º columna - 1º columna). Si la Mercancía Vendida a PVP es = 0 no debe mostrar resultado.
if($MVpvp > 0 ){$MGB=$MVpvp-$ME; }else{$MGB="";};
$datt[$idt][$gr]['MGB']=$MGB; $sumMGB[$idt]=($sumMGB[$idt]*1)+($MGB*1);

#### Piezas es el número total de piezas vendidas por esa tienda, por subgrupos.
if(array_key_exists($gr, $resultV[$idt])){$PIEZ=$resultV[$idt][$gr]['piez'];}else{$PIEZ="";};
$datt[$idt][$gr]['PIEZ']=$PIEZ;

##### Margen Bº Pieza: es el Margen de Beneficio / Piezas.
if($PIEZ>0){$MGPP=$MGB/$PIEZ;};
$datt[$idt][$gr]['MGPP']=$MGPP;

	
}}

	
$grid=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();$p=1;$sumas=array();
	
$fila=0;$adfil=0;	$first=1;

$flini=3;$lg="";
foreach ($datt as $idt => $vals) {
if(!array_key_exists($idt,$sumas)){$sumas[$idt]=array();};

$fila++;$adfil++;
$Mrang["B$fila:C$fila"]=1;
$BOLDrang["B$fila"]=1;
$crang["B$fila"]='91E3FF';
$grid[$fila]['B']=$tiendasN[$idt];


$fila++;$adfil++;
$grid[$fila]['C']='MERC.ENVIADA';
$grid[$fila]['D']='MERC.VENDIDA';
$grid[$fila]['E']='% VENTAS';
$grid[$fila]['F']='DIFERENCIA';
$grid[$fila]['G']='DIFERENCIA EU';

$grid[$fila]['I']='MERC.VEND PVP';
$grid[$fila]['J']='MARGEN Bº';
$grid[$fila]['K']='% Bº';
$grid[$fila]['L']='PIEZAS';
$grid[$fila]['M']='MARGEN Bº PIEZA';

$BOLDrang	['A' . $fila .':M' .$fila]=5;
$align		['A' . $fila .':M' .$fila]='C';

$cMGM=array();
$cMGPP=array();




foreach ($vals as $gru => $dat){

	
$fil=$dat['idfil']+$adfil;		

$BOLDrang   ['C' . $fil .':M' .$fil]=2;    
$align		['A' . $fil .':M' .$fil]='C';
$BTrang 	['B' . $fil .':M' .$fil]=1;

$grid[$fil]['B']=$gru;

$grid[$fil]['C']=number_format($dat['ME']*1,2,',','.');	 if(!array_key_exists('C',$sumas[$idt])){$sumas[$idt]['C']=$dat['ME'];}else{$sumas[$idt]['C']=$sumas[$idt]['C']+$dat['ME'];};	
$grid[$fil]['D']=number_format($dat['MV']*1,2,',','.');	 if(!array_key_exists('D',$sumas[$idt])){$sumas[$idt]['D']=$dat['MV'];}else{$sumas[$idt]['D']=$sumas[$idt]['D']+$dat['MV'];};	

$cpV[$fil]=$dat['pV'];	
if($dat['pV']){$E=number_format($dat['pV']*1,2,',','.'). "%";}else{$E="";};
$grid[$fil]['E']=$E;	

if($dat['DF']){
	$F=number_format($dat['DF']*1,2,',','.'). "%";
	if($dat['DF']<0){$crang["F$fil"]='94FF70';}else{$crang["F$fil"]='FFB6A3';};	
	}else{$F="";};
$grid[$fil]['F']=$F; 

if($dat['DE']){$G=number_format($dat['DE']*1,2,',','.'); $crang["G$fil"]='FFB6A3';  }else{$G="";};
$grid[$fil]['G']=$G;		if(!array_key_exists('G',$sumas[$idt])){$sumas[$idt]['G']=$dat['DE'];}else{$sumas[$idt]['G']=$sumas[$idt]['G']+$dat['DE'];};

if($dat['MVpvp']){$I=number_format($dat['MVpvp']*1,2,',','.');}else{$I="";};
$grid[$fil]['I']=$I;	    if(!array_key_exists('I',$sumas[$idt])){$sumas[$idt]['I']=$dat['MVpvp'];}else{$sumas[$idt]['I']=$sumas[$idt]['I']+$dat['MVpvp'];};


if($dat['MGB']){$J=number_format($dat['MGB']*1,2,',','.');$cMGM[$fil]=$dat['MGB'];}else{$J="";};
$grid[$fil]['J']=$J;	   if(!array_key_exists('J',$sumas[$idt])){$sumas[$idt]['J']=$dat['MGB'];}else{$sumas[$idt]['J']=$sumas[$idt]['J']+$dat['MGB'];};

####% Bº: es el % que representa el Margen de Beneficio de cada subgrupo. Margen de Bº de cada subgrupo / suma total Margen de Bº. (Cada registro de la 7ª columna entre la suma total de esa columna).
$pcB=(($dat['MGB'])/$sumMGB[$idt])*100;    
if($pcB){$K=number_format($pcB,2,',','.') . "%"; $cPCB[$fil]=$pcB;}else{$K="";};
$grid[$fil]['K']=$K;	

$grid[$fil]['L']=$dat['PIEZ'];	if(!array_key_exists('L',$sumas[$idt])){$sumas[$idt]['L']=$dat['PIEZ'];}else{$sumas[$idt]['L']=$sumas[$idt]['L']+$dat['PIEZ'];};

$cMGPP[$fil]=$dat['MGPP'];
$grid[$fil]['M']=number_format($dat['MGPP'],2,',','.');	



$flfin=$fil;
$g=substr($gru, 0,1);
if($first){$first=0;$lg=$g;};
if($lg!=$g){$lg=$g;	$flini=$flfin;};
$lats[$flini]=$flfin;
$ngs[$flini]=$nomgru[$g];


}





arsort($cpV);  
$c=0; foreach ($cpV as $idf => $i) {$c++; if($c<=10){$crang["E$idf"]='94FF70';}; };

arsort($cMGM);  
$c=0; foreach ($cMGM as $idf => $i) {$c++; if($c<=10){$crang["J$idf"]='94FF70';}; };
asort($cMGM);  
$c=0; foreach ($cMGM as $idf => $i) {$c++; if($c<=10){$crang["J$idf"]='FFB6A3';}; };


arsort($cMGPP);  
$c=0; foreach ($cMGPP as $idf => $i) {$c++; if($c<=10){$crang["M$idf"]='94FF70';}; };
asort($cMGPP);  
$c=0; foreach ($cMGPP as $idf => $i) {$c++; if($c<=10){$crang["M$idf"]='FFB6A3';}; };


arsort($cPCB);  
$c=0; foreach ($cPCB as $idf => $i) {$c++; if($c<=10){$crang["K$idf"]='94FF70';}; };
asort($cPCB);  
$c=0; foreach ($cPCB as $idf => $i) {$c++; if($c<=10){$crang["K$idf"]='FFB6A3';}; };


$fila=$fil;

//print_r($lats);
//echo $fila;
foreach ($lats as $flini => $flfin) {
if($flfin>$fila){$flfin=$fila;};	

	$Mrang["A$flini:A$flfin"]=1;
	$angle["A$flini"]=90;
	$grid[$flini]['A']=$ngs[$flini];
	$BOLDrang	["A$flini"]=1;
	$align		["A$flini"]='VC';
	$BTrang 	['A' . $flini .':M' .$flfin]=3;
	
	}

$fila++;$adfil++;$adfil++;$fila++;
foreach ($sumas[$idt] as $cel => $value) {
if($cel!='L'){$value=number_format($value,2,',','.');};	
$grid[$fila][$cel]=$value;	
}
$BOLDrang   ['C' . $fila .':M' .$fila]=1;    
$align		['C' . $fila .':M' .$fila]='C';
$BTrang 	['C' . $fila .':M' .$fila]=1;
$fila++;$fila++;$adfil++;$adfil++;

$paginas[$fila]=1;$lats=array();

}







$anchos['A']=6;
$anchos['B']=5;
$anchos['C']=21;
$anchos['D']=21;
$anchos['E']=16;
$anchos['F']=18;
$anchos['G']=22;

$anchos['H']=2;

$anchos['I']=23;
$anchos['J']=18;
$anchos['K']=12;
$anchos['L']=14;
$anchos['M']=22;

if(count($grid)>0){
	
$_SESSION['angle']=$angle;
$_SESSION['BOLDrang']=$BOLDrang;
//$_SESSION['cgd'] = $cdg; 
$_SESSION['grid'] = $grid; 
$_SESSION['anchos'] = $anchos;
$_SESSION['align'] = $align;
$_SESSION['crang']=$crang;
$_SESSION['Mrang']=$Mrang;
$_SESSION['BTrang']=$BTrang;
$_SESSION['format']=$format;
$_SESSION['paginas']=$paginas;
$_SESSION['nomfil']="MargenBeneficios";
$_SESSION['BOLDrang']=$BOLDrang;
$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format)+1000;

}else{
$res['ng']=0;	
}


echo json_encode($res);






?>

