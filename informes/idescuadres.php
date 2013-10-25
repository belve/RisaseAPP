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
$paginas=array();
$format=array();
$BOLDrang=array();
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
$queryp= "select distinct agrupar from pedidos where agrupar is not null $codigosIN ;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$agrupaciones .=$row['agrupar'] . ",";};
$agrupaciones=substr($agrupaciones, 0,-1);


$queryp= "select id from agrupedidos where id IN ($agrupaciones) AND (estado='T' OR estado='E' OR estado='F');";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$peds .=$row['id'] . ",";};


$peds=substr($peds, 0,-1);


$queryp= "select (select codbarras from articulos where id=id_articulo) as codbarras, 
(select refprov from articulos where id=id_articulo) as refprov, 
id_tienda, sum(cantidad) as cant from pedidos where agrupar in ($peds) $codigosIN group by id_articulo, id_tienda;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};$enviados=array();
while ($row = $dbnivel->fetchassoc()){
	
$cd=$row['codbarras']; $idt=$row['id_tienda']; $cant=$row['cant']; $refprov=$row['refprov'];

if(array_key_exists($idt,$tiendasN)){
if(!array_key_exists($cd, $codigos)){
$codigos[$cd]="$cd / $refprov";
$g=substr($cd,0,1);$sg=substr($cd,1,1);$c=substr($cd,4);
$cord[$g][$sg][$c]=$cd;
$cods .=$cd . ","; 
$totcod[$cd]=1;
}
}


$tiends[$idt]=1;
$enviados[$idt][$cd]=$cant;
}


############ aqui debo sumar lo enviado en fijarstock
$queryp= "select (select codbarras from articulos where id=id_articulo) as codbarras, 
id_tienda, sum(suma) as cant from fij_stock where bd=2 $codigosIN group by id_articulo, id_tienda;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$cd=$row['codbarras']; $idt=$row['id_tienda']; $cant=$row['cant'];

if(array_key_exists($idt,$tiendasN)){ 
if(array_key_exists($idt, $enviados)){
if(array_key_exists($cd, $enviados[$idt])){	
$enviados[$idt][$cd]=$enviados[$idt][$cd]+$cant;	

}else{$enviados[$idt][$cd]=$cant;	}
}else{$enviados[$idt][$cd]=$cant;	}
}


}
########################################################




$cods=substr($cods, 0,-1);

$codv=array();
$queryp= "select id_articulo, id_tienda, sum(cantidad) as cant, sum(importe * cantidad) as imp, importe from ticket_det where id_articulo IN ($cods) group by id_articulo, id_tienda;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
$cods2="";
while ($row = $dbnivel->fetchassoc()){
$cd=$row['id_articulo']; $idt=$row['id_tienda']; $cant=$row['cant']; $imp=$row['imp'];
if(array_key_exists($idt,$tiendasN)){
$vendidos[$idt][$cd]=$cant;
}
}
$cods2=substr($cods2, 0,-1);


if (!$dbnivel->close()){die($dbnivel->error());};





$codsF="";$cordF=array();
foreach ($vendidos as $idt => $vals) { foreach ($vals as $cb => $qty) {
	
	if(array_key_exists($idt, $enviados)){
	if(array_key_exists($cb, $enviados[$idt])){
	$qty2=$enviados[$idt][$cb];	
	}else{$qty2=0;}
	}else{
	$qty2=0;	
	}	
	
	if($qty>$qty2){
	$g=substr($cb,0,1);$sg=substr($cb,1,1);$c=substr($cb,4);
	$cordF[$idt][$g][$sg][$c]=$cb;
	$codsF .=$cb . ","; 	
	}
		
	
}}



$cBAK=array();

$act=1;$actO='A';
if($act==1){
$cdg=array();
if(count($cordF)>0){
ksort($cordF);
foreach ($cordF as $idt => $valuess) {$cBAK[$idt]="";
if($actO=='A'){ksort($valuess);}else{krsort($valuess);} 
foreach ($valuess as $gu => $subs) {
	if($actO=='A'){ksort($subs);}else{krsort($subs);} foreach ($subs as $sb => $ccs)	{
		if($actO=='A'){ksort($ccs);}else{krsort($ccs);} foreach ($ccs as $cd => $codbar) {
$cdgP[$idt][$codbar]=1;
$cBAK[$idt] .="$codbar,";
}}}}}}




foreach ($tiendas as $key => $value) {
if(array_key_exists($key, $cdgP)){	
$cdg[$key]=$cdgP[$key];	
}}



$dbBAK=new DB('192.168.1.11','edu','admin','tpv_backup');
if (!$dbBAK->open()){die($dbBAK->error());};

if(count($cBAK)>0){
foreach ($cBAK as $idt => $codis) {
	$codis=substr($codis, 0,-1);
	$queryp= "select cod, stock from stocklocal_$idt where cod IN ($codis);";
	$dbBAK->query($queryp); if($debug){echo "$queryp \n\n";};
	while ($row = $dbBAK->fetchassoc()){
	$cd=$row['cod']; $cant=$row['stock']; 
	$stocks[$idt][$cd]=$cant;
	}
}}


if (!$dbBAK->close()){die($dbBAK->error());};




$gridD=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();

$cols[1]['A']='B';
$cols[1]['B']='C';
$cols[1]['C']='D';
$cols[1]['D']='E';

$cols[2]['A']='G';
$cols[2]['B']='H';
$cols[2]['C']='I';
$cols[2]['D']='J';


$cols[3]['A']='L';
$cols[3]['B']='M';
$cols[3]['C']='N';



$fila=0;$count=0;$cabecera=1;$lastfil=$fila;$f=0;$romp=0;$pt=1;$first=1;$Lend=50;$poc=0;
$c=1; $lidt="";
if(count($cdg)>0){ foreach ($cdg as $idt => $valueC) {
foreach ($valueC as $codbar => $point) {
if($first){$lidt=$idt;$first=0;};		
	
	


if($count > 49){
if ($c < 2){$Lend=$fila ;$c++; $fila=$lastfil+3; $count=3; $poc=1;}else{  $romp=1;$poc=1;};
}






if($lidt!=$idt){
	$romp=1;	
	$lidt=$idt;
	if($poc){$fila=$Lend;$poc=0;};
}



if($romp){$romp=0;
$c=1;
$paginas[$fila]=1;
$lastfil=$fila; $count=0;
$romp=0;
$pt=1;


}	



$A=$cols[$c]['A'];
$B=$cols[$c]['B'];
$C=$cols[$c]['C'];
$D=$cols[$c]['D'];


if($pt){
$fila++; $count++;	
$grid[$fila][$A]=$tiendasN[$idt];
$align		['B' . $fila . ':' . 'J' . $fila]='C';
$Mrang		['B' . $fila . ':' . 'J' . $fila]=1;
$BOLDrang	['B' . $fila . ':' . 'J' . $fila]=1;
$crang		['B' . $fila . ':' . 'J' . $fila]='8AE65C'; 	
$fila++; $count++;

$grid[$fila]['B']='CODIGO';
$grid[$fila]['C']='STK';
$grid[$fila]['D']='ORD';
$grid[$fila]['E']='TIE';

$grid[$fila]['G']='CODIGO';
$grid[$fila]['H']='STK';
$grid[$fila]['I']='ORD';
$grid[$fila]['J']='TIE';


$align		['B' . $fila . ':' . 'E' . $fila]='C';
$BOLDrang	['B' . $fila . ':' . 'E' . $fila]=1;	
$BTrang		['B' . $fila . ':' . 'E' . $fila]=1;

$align		['G' . $fila . ':' . 'J' . $fila]='C';
$BOLDrang	['G' . $fila . ':' . 'J' . $fila]=1;	
$BTrang		['G' . $fila . ':' . 'J' . $fila]=1;



$fila++; $count++;



$pt=0;
}






$S="";
if(array_key_exists($codbar, $stocks[$idt])){$S=$stocks[$idt][$codbar];};

$fila++; $count++;
$grid[$fila][$A]=$codbar;
$grid[$fila][$B]=$S;
$grid[$fila][$C]='';//$fila;
$grid[$fila][$D]='';//$count;

$BTrang		[$A . $fila . ':' . $D . $fila]=1;
$BOLDrang	[$A . $fila . ':' . $D . $fila]=2;
$align		[$A . $fila . ':' . $D . $fila]='C';




}}

$anchos['A']=20;

$anchos['B']=18;
$anchos['C']=8;
$anchos['D']=8;
$anchos['E']=8;

$anchos['F']=4;
$anchos['G']=18;
$anchos['H']=8;
$anchos['I']=8;
$anchos['J']=8;
$anchos['K']=4;
$anchos['M']=10;


$_SESSION['cgd'] = $cdg; 
$_SESSION['grid'] = $grid; 
$_SESSION['anchos'] = $anchos;
$_SESSION['align'] = $align;
$_SESSION['crang']=$crang;
$_SESSION['Mrang']=$Mrang;
$_SESSION['BTrang']=$BTrang;
$_SESSION['paginas']=$paginas;
$_SESSION['format']=$format;
$_SESSION['nomfil']="DescuadresStock-" . date('Y') . date('m') . date('d');
$_SESSION['BOLDrang']=$BOLDrang;
$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);


}else{
$res['ng']=0;	
}


echo json_encode($res);
//echo "rows: " . (count($grid)+count($anchos)+count($align)+count($crang));

//$_SESSION['vendidos'] = $vendidos;
//$_SESSION['stocks'] = $stocks;
//$_SESSION['tiendas'] = $tiendas;
//if($debug==1){print_r($_SESSION);};

?>