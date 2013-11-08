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






if($risase){$db='risasa';}else{$db='risase';};
$dbn=new DB('192.168.1.11','edu','admin',$db);

if (!$dbn->open()){die($dbn->error());};
$queryp= "select id_tienda, hora, sum(importe) as qty from tickets where fecha >= '$fini' AND fecha <= '$ffin' AND id_tienda IN ($ttss) GROUP BY id_tienda, hora ORDER BY  hora ASC;";	
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
while ($row = $dbn->fetchassoc()){
$idt=$row['id_tienda']; $hora=$row['hora']; $qty=$row['qty'];	
$datos[$idt][$hora]=$qty;
}




if (!$dbn->close()){die($dbn->error());};

$angle=array();
$grid=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();$p=1;$sumas=array();

$col[7]='C';	$col[8]='D';	$col[9]='E';	$col[10]='F';
$col[11]='G';	$col[12]='H';	$col[13]='I';	$col[14]='J';
$col[15]='K';	$col[16]='L';	$col[17]='M';	$col[18]='N';
$col[19]='O';	$col[20]='P';	$col[21]='Q';	$col[22]='R';
$col[23]='S';	

	
$anchos['A']=1;	
$anchos['B']=12;	
$anchos['T']=18;


$fila=1; $tots=array();


$dh=6;  $grid[$fila]['B']='TIENDA';   $grid[$fila]['T']='TOTAL';  $BTrang		['B' . $fila . ':' . 'T' . $fila]=1;
while ($dh < 23) {$dh++; $grid[$fila][$col[$dh]]=$dh; };
$BOLDrang	['B' . $fila . ':' . 'T' . $fila]=1;
$align		['B' . $fila . ':' . 'T' . $fila]='C'; 


foreach ($tiendas as $idt => $nomt) {if(array_key_exists($idt, $datos)){
$fila++;			
$days=$datos[$idt];

$grid[$fila]['B']=$nomt; 
$BOLDrang	['B' . $fila]=1;


$dh=6;  $sum=0;
while ($dh < 23) {$dh++;

$anchos[$col[$dh]]=15;

if(array_key_exists($dh, $days)){$qty=$days[$dh];}else{$qty=0;};
$sum=$sum+$qty;

if(array_key_exists($dh, $tots)){$tots[$dh]=$tots[$dh]+$qty;}else{$tots[$dh]=$qty;};

$qty=number_format($qty,2,',','.');
$grid[$fila][$col[$dh]]=$qty; 

}

$grid[$fila]['T']=number_format($sum,2,',','.'); 
$BOLDrang	['T' . $fila]=1;

if($p==1){$p=0;$color='DDDDDD';}else{$p=1;$color='FFFFFF';}

$BOLDrang	['C' . $fila . ':' . 'S' . $fila]=2;
$align		['B' . $fila . ':' . 'T' . $fila]='C'; 
$crang		['B' . $fila . ':' . 'T' . $fila]=$color;
$BTrang		['B' . $fila . ':' . 'T' . $fila]=1;

}}

$fila++;

$dh=6;  $sum=0;
while ($dh < 23) {$dh++;
if(array_key_exists($dh, $tots)){$qty=$tots[$dh];}else{$$qty=0;};
$sum=$sum+$qty;
$qty=number_format($qty,2,',','.');
$grid[$fila][$col[$dh]]=$qty; 
}

$grid[$fila]['B']='TOTAL';
$grid[$fila]['T']=number_format($sum,2,',','.'); 
$BOLDrang	['B' . $fila . ':' . 'T' . $fila]=1;
$align		['B' . $fila . ':' . 'T' . $fila]='C'; 
$BTrang		['B' . $fila . ':' . 'T' . $fila]=1;




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
$_SESSION['nomfil']="PorHoras-" . $mes;
$_SESSION['BOLDrang']=$BOLDrang;
$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);

}else{
$res['ng']=0;	
}


echo json_encode($res);






?>

