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
$format=array(); $BOLDrang=array(); $tipo=""; $temp="";$ccn=0;$total=0;
$ttss="";$rot=0; $dev=0; 
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$ttss=substr($ttss, 0,-1);


$fini=substr($mes, 3,4) . "-" . substr($mes, 0,2) . "-01";
$ffin=substr($mes, 3,4) . "-" . substr($mes, 0,2) . "-31";


if($risase){$db='risasa';}else{$db='risase';};
$dbn=new DB('192.168.1.11','edu','admin',$db);

if (!$dbn->open()){die($dbn->error());};
$queryp= "select id_tienda, fecha, sum(importe) as qty from tickets where fecha >= '$fini' AND fecha <= '$ffin' AND id_tienda IN ($ttss) GROUP BY id_tienda, fecha;";	
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
while ($row = $dbn->fetchassoc()){
$idt=$row['id_tienda']; $fecha=(substr($row['fecha'],8,2)) * 1; $qty=$row['qty'];	
$datos[$idt][$fecha]=$qty;
}




if (!$dbn->close()){die($dbn->error());};


$grid=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();$p=1;$sumas=array();

$col[1]='C';	$col[2]='D';	$col[3]='E';	$col[4]='F';
$col[5]='G';	$col[6]='H';	$col[7]='I';	$col[8]='J';
$col[9]='K';	$col[10]='L';	$col[11]='M';	$col[12]='N';
$col[13]='O';	$col[14]='P';	$col[15]='Q';	$col[16]='R';
$col[17]='S';	$col[18]='T';	$col[19]='U';	$col[20]='V';
$col[21]='W';	$col[22]='X';	$col[23]='Y';	$col[24]='Z';
$col[25]='AA';	$col[26]='AB';	$col[27]='AC';	$col[28]='AD';
$col[29]='AE';	$col[30]='AF';	$col[31]='AG';

$fila=1;

$grid[$fila]['B']='TIENDA'; 
$BOLDrang	['B' . $fila . ':' . 'AG' . $fila]=1;
$align		['C' . $fila . ':' . 'AG' . $fila]='C';
$BTrang		['C' . $fila . ':' . 'AG' . $fila]=1;
foreach ($col as $dia => $cl) {$grid[$fila][$cl]=$dia; $anchos[$cl]=12;};


foreach ($datos as $idt => $days) {$ndo=1;
if(!$frqcia){if(array_key_exists($idt,$franq)){$ndo=0;}else{$ndo=1;}; };	
if($ndo){
		
$fila++;	
$grid[$fila]['B']=$tiendas[$idt]; 	
$BOLDrang	['B' . $fila]=1;

if($p==1){$p=0;$color='DDDDDD';}else{$p=1;$color='FFFFFF';}
foreach ($days as $dd => $qty){$qty=number_format($qty,2,',','.');
$grid[$fila][$col[$dd]]=$qty; 	

if(array_key_exists($dd, $sumas)){$sumas[$dd]=$sumas[$dd]+$qty;}else{$sumas[$dd]=$qty;};
}
$BOLDrang	['C' . $fila . ':' . 'AG' . $fila]=2;
$BTrang		['C' . $fila . ':' . 'AG' . $fila]=1;
$crang		['C' . $fila . ':' . 'AG' . $fila]=$color;
$align		['C' . $fila . ':' . 'AG' . $fila]='R'; 
}}

$fila++;$fila++;
$grid[$fila]['B']='TOTAL:';
foreach ($sumas as $dd => $qty) {$qty=$qty*1;
$qty=number_format($qty,2,',','.');
$grid[$fila][$col[$dd]]=$qty; 		
}
$BOLDrang	['B' . $fila . ':' . 'AG' . $fila]=1;
$BTrang		['C' . $fila . ':' . 'AG' . $fila]=1;
$crang		['C' . $fila . ':' . 'AG' . $fila]=$color;
$align		['C' . $fila . ':' . 'AG' . $fila]='R';  

$anchos['A']=1;
$anchos['B']=15;



if(count($grid)>0){

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
$_SESSION['nomfil']="PorDias-" . $mes;
$_SESSION['BOLDrang']=$BOLDrang;
$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);

}else{
$res['ng']=0;	
}


echo json_encode($res);






?>

