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
$paginas=array();$grid=array();$cord=array();$datos=array();$anios="";
$fini="";
$ffin="";$mes="";
$format=array(); $BOLDrang=array(); $tipo=""; $temp="";$ccn=0;$total=0;$p=0;
$ttss="";$rot=0; $dev=0; 
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$ttss=substr($ttss, 0,-1);$emps=array();
$frqcia=1;

$anios=date('Y') . "," . $anios;
$anno=explode(',', substr($anios, 0,-1));



if($risase){$db='risasa';}else{$db='risase';};
$dbn=new DB('192.168.1.11','edu','admin',$db);

if (!$dbn->open()){die($dbn->error());};

foreach ($anno as $aa => $anio) {
	

$fini2=$anio . "-" . substr($fini, 3,2) . "-" . substr($fini, 0,2);
$ffin2=$anio . "-" . substr($ffin, 3,2) . "-" . substr($ffin, 0,2);

$queryp= "select id_tienda, sum(importe) as qty 
from tickets where fecha >= '$fini2' AND fecha <= '$ffin2' AND id_tienda IN ($ttss) GROUP BY id_tienda;";	
$dbn->query($queryp);
if($debug){echo "$queryp \n\n";};
echo $dbn->error();
	while ($row = $dbn->fetchassoc()){
	$idt=$row['id_tienda'];$qty=$row['qty'];	
	$datos[$idt][$anio]=$qty;
	}

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
$col[15]='K';	$col[16]='L';	$col[17]='M';	$col[18]='N';
$col[19]='O';	$col[20]='P';	$col[21]='Q';	$col[22]='R';
$col[23]='S';	

	
$anchos['A']=1;	
$anchos['B']=12;	

$anchos['C']=18;
$anchos['D']=3;

$anchos['E']=18;
$anchos['F']=8;

$anchos['G']=18;
$anchos['H']=8;

$anchos['I']=18;
$anchos['J']=8;


$fila=2; $tots=array();$first=1;

$grid[1]['B']='TIENDA'; 


$BOLDrang	['B1:J1']=1;
$align		['B1:J1']='C'; 
$BTrang		['B1:J1']=1;


foreach ($tiendas as $idt => $nomt) {if(array_key_exists($idt, $datos)){
			
			
			
$days=$datos[$idt];
$grid[$fila]['B']=$nomt; 

$dh=0;
foreach ($days as $year => $value) {
$cl=($dh*2)+1;			
		
if($first){
$grid[1][$col[$cl]]=$year; 	
if($cl>1){$grid[1][$col[$cl+1]]='%';}; 
}	

if($cl==1){$tot=$value;}

if(($cl>1)&&($value>0)){
$porc=(($tot/$tot)*100) - (($value/$tot)*100);$porc=round($porc,2);
$grid[$fila][$col[$cl+1]]=$porc; 
}

$value=number_format($value,2,',','.');
$grid[$fila][$col[$cl]]=$value; 


//$porc="t:$tot v:$value";

$dh++;
}
$first=0;



if($p==1){$p=0;$color='DDDDDD';}else{$p=1;$color='FFFFFF';}

$BOLDrang	['B' . $fila]=1;
$BOLDrang	['C' . $fila . ':' . 'J' . $fila]=2;
$align		['B' . $fila . ':' . 'J' . $fila]='C'; 
$crang		['B' . $fila . ':' . 'J' . $fila]=$color;
$BTrang		['B' . $fila . ':' . 'J' . $fila]=1;


$fila++;

}}







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

