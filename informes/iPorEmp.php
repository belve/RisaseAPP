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
$ttss=substr($ttss, 0,-1);$emps=array();
$frqcia=1;

$fini=substr($fini, 6,4) . "-" . substr($fini, 3,2) . "-" . substr($fini, 0,2);
$ffin=substr($ffin, 6,4) . "-" . substr($ffin, 3,2) . "-" . substr($ffin, 0,2);


if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id, (select id from tiendas where tiendas.id_tienda=empleados.id_tienda) as id_tienda, CONCAT_WS(' ', nombre, apellido1, apellido2) as nom, orden from empleados WHERE trabajando='S' order by id_tienda, orden ASC;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$count++;
$emps[$row['id_tienda']][$row['id']]=$row['nom'];
};



if (!$dbnivel->close()){die($dbnivel->error());};



if($risase){$db='risasa';}else{$db='risase';};
$dbn=new DB('192.168.1.11','edu','admin',$db);

if (!$dbn->open()){die($dbn->error());};
$queryp= "select id_tienda, id_empleado, sum(importe) as qty from tickets where fecha >= '$fini' AND fecha <= '$ffin' AND id_tienda IN ($ttss) GROUP BY id_tienda, id_empleado;";	
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
while ($row = $dbn->fetchassoc()){
$idt=$row['id_tienda']; $id_empleado=$row['id_empleado']; $qty=$row['qty'];	
$datos[$idt][$id_empleado]=$qty;
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

$fila=0;$maxc=0;



foreach ($tiendas as $idt => $nomt) {if(array_key_exists($idt, $datos)){
$fila++;			
	
	
$days=$datos[$idt];	


$dd=0; $dt=$emps[$idt]; $sum=0;

foreach ($dt as $idemp => $nomemp) {$dd++;

if(array_key_exists($idemp, $days)){$qty=$days[$idemp];}else{$qty=0;};
$sum=$sum+$qty;
$qty=number_format($qty,2,',','.');

$grid[$fila][$col[$dd]]=$nomemp; $grid[$fila]['B']=$nomt; 
$grid[$fila+1][$col[$dd]]=$qty;  //$grid[$fila+1]['B']=$nomt;

}

$dd++;

$BOLDrang	['B' . $fila . ':' . 'H' . $fila]=1;
$BOLDrang	['B' . ($fila+1) . ':' . 'H' . ($fila+1)]=2;
$tots[$fila+1]=$sum;

if($dd > $maxc){$maxc=$dd;};





/*
$BOLDrang	['C' . $fila . ':' . 'AG' . $fila+1]=2;
$BTrang		['B' . $fila . ':' . 'AG' . $fila+1]=1;
$crang		['C' . $fila . ':' . 'AG' . $fila+1]=$color;
$align		['B' . $fila . ':' . 'AG' . $fila+1]='C'; 
 */
 
 $fila++;




}}

foreach ($tots as $fil => $total) {
$grid[$fil][$col[$maxc]]=number_format($total,2,',','.');
$crang		['B' . $fil . ':' . $col[$maxc] . $fil]='DDDDDD';	
}

$grid[1][$col[$maxc]]='TOTAL';$BOLDrang	[$col[$maxc] . '1']=1;

$BTrang		['B1:' . $col[$maxc] . $fila]=1;
$align		['B1:' . $col[$maxc] . $fila]='C'; 




	



$anchos['A']=1;
$anchos['B']=15;
$anchos['C']=35;
$anchos['D']=35;
$anchos['E']=35;
$anchos['F']=35;
$anchos['G']=35;
$anchos['H']=35;
$anchos['I']=35;
$anchos['J']=15;
$anchos['K']=15;
$anchos['M']=15;
$anchos['N']=15;


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

