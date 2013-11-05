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
$frqcia=1;

$fini=substr($mes, 3,4) . "-" . substr($mes, 0,2) . "-01";
$ffin=substr($mes, 3,4) . "-" . substr($mes, 0,2) . "-31";



if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id, orden, (select id from tiendas where tiendas.id_tienda=empleados.id_tienda) as id_tienda, CONCAT_WS(' ', nombre, apellido1, apellido2) as nom, orden from empleados order by id_tienda, orden ASC;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$count++;
$ord=$row['orden'];
if($ord==0){$ord=100;};
$empsn[$row['id_tienda']][$ord][$row['id']]=$row['nom'];
};



if (!$dbnivel->close()){die($dbnivel->error());};





if($risase){$db='risasa';}else{$db='risase';};
$dbn=new DB('192.168.1.11','edu','admin',$db);

if (!$dbn->open()){die($dbn->error());};
$queryp= "select id_tienda, id_empleado, fecha, sum(importe) as qty from tickets where fecha >= '$fini' AND fecha <= '$ffin' AND id_tienda IN ($ttss) GROUP BY id_empleado, fecha ORDER BY id_tienda, id_empleado, fecha;";	
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
while ($row = $dbn->fetchassoc()){
$idt=$row['id_tienda']; $ide=$row['id_empleado']; $fecha=(substr($row['fecha'],8,2)) * 1; $qty=$row['qty'];	
$datos[$idt][$ide][$fecha]=$qty;
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

$fila=1;


foreach ($tiendas as $idt => $nomt) {if(array_key_exists($idt, $datos)){
$totales=array();	
$emps=$datos[$idt];	
$empi=$empsn[$idt];

$Mrang['C' . $fila .':G' .$fila]=1;
$align['C' . $fila]='C';
$crang['C' . $fila]='99CCFF';
$grid[$fila]['C']=$tiendasN[$idt];
$BOLDrang	['C' . $fila]=1;
$fila++;

$cc=0;

ksort($empi);
foreach ($empi as $ord => $empi2) {
foreach ($empi2 as $ide => $nom) {
if(array_key_exists($ide, $emps)){
	$cc++;	$anchos[$col[$cc]]=35;
	$days=$emps[$ide];
	$grid[$fila][$col[$cc]]=$nom;// . "/$ord" ;
	
	$d=1;$p=0;
	while ($d <= 31){
			
		if( array_key_exists($d, $days) ){ $qty=$days[$d]; }else{ $qty=0; };
		
		if(array_key_exists($cc, $totales)){$totales[$cc]=$totales[$cc]+$qty;}else{$totales[$cc]=$qty;};
		
		$nf=($fila*1)+($d*1);
		$grid[$nf]['B']=$d;
			
			$grid[$nf][$col[$cc]]=number_format($qty,2,',','.');;
			
			if($p==1){$p=0;$color='DDDDDD';}else{$p=1;$color='FFFFFF';}
			
			$BOLDrang	['B' . $nf]=1;
			$BTrang		['B' . $nf]=1;
			$crang		['B' . $nf]=$color;
			$align		['B' . $nf]='C';
			
			$crang		[$col[$cc] . $nf]=$color;
			
			
		$d++;
		}
	
}}}
$grid[$fila][$col[$cc+1]]='GASTOS';		
$BOLDrang	['C' . $fila . ':' . $col[$cc+1] . $fila]=1;
$align		['C' . $fila . ':' . $col[$cc+1] . $fila]='C'; 

$anchos[$col[$cc+1]]=35;

$BOLDrang	['C' . ($fila+1) . ':' . $col[$cc+1] . ($fila+31)]=2;
$BTrang		['B' . ($fila+1) . ':' . $col[$cc+1] . ($fila+31)]=1;
$align		['B' . ($fila+1) . ':' . $col[$cc+1] . ($fila+31)]='C'; 





//$grid[$fila]['B']=$tiendas[$idt]; 	
//$BOLDrang	['B' . $fila]=1;

//if($p==1){$p=0;$color='DDDDDD';}else{$p=1;$color='FFFFFF';}
//$sumt=0;

//$BOLDrang	['C' . $fila . ':' . 'AG' . $fila]=2;
//$BTrang		['B' . $fila . ':' . 'AG' . $fila]=1;
//$crang		['C' . $fila . ':' . 'AG' . $fila]=$color;
//$align		['B' . $fila . ':' . 'AG' . $fila]='C'; 

//$grid[$fila]['AH']=number_format($sumt,2,',','.');


$fila=$fila+32;

$cc=0;
foreach ($totales as $cca => $qty) {
$grid[$fila][$col[$cca]]=number_format($qty,2,',','.');;	
if($cca>$cc){$cc=$cca;};
}

$BOLDrang	['C' . ($fila) . ':' . $col[$cc+1] . ($fila)]=1;
$BTrang		['C' . ($fila) . ':' . $col[$cc+1] . ($fila)]=1;
$align		['C' . ($fila) . ':' . $col[$cc+1] . ($fila)]='C'; 

$fila++;
$paginas[$fila-1]=1;	
}}






$anchos['A']=1;
$anchos['B']=5;

//$Mrang['H3:H14']=1;
//$angle['H3']=90;
//$grid[3]['H']='prueba';

if(count($grid)>0){

//$_SESSION['angle']=$angle;
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
$_SESSION['nomfil']="Mensual-" . $mes;
$_SESSION['BOLDrang']=$BOLDrang;
$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);

}else{
$res['ng']=0;	
}


echo json_encode($res);






?>

