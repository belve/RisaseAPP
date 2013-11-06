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
$fini2=$fini;$ffin2=$ffin;
$fini=substr($fini, 6,4) . "-" . substr($fini, 3,2) . "-" . substr($fini, 0,2);
$ffin=substr($ffin, 6,4) . "-" . substr($ffin, 3,2) . "-" . substr($ffin, 0,2);



if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id, orden, id_tienda, nombre, franquicia from tiendas";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$idttt=$row['id'];$orden=$row['orden'];$nidtienda=$row['id_tienda'];$f=$row['franquicia'];
$tiendas2[$idttt]=$nidtienda;
}
if (!$dbnivel->close()){die($dbnivel->error());};



$tot=0;

if($risase){$db='risasa';}else{$db='risase';};
$dbn=new DB('192.168.1.11','edu','admin',$db);

if (!$dbn->open()){die($dbn->error());};
$queryp= "select id_tienda, sum(importe) as qty from tickets where fecha >= '$fini' AND fecha <= '$ffin' GROUP BY id_tienda ORDER BY qty DESC;";	
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
while ($row = $dbn->fetchassoc()){
$idt=$row['id_tienda']; $qty=$row['qty']; $tot=$tot+$qty;	
$datos[$idt]=$qty;
}
if (!$dbn->close()){die($dbn->error());};




$grid=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();$p=1;$sumas=array();




$fila=1; $tots=array();

$Mrang["B$fila:D$fila"]=1;
$grid[$fila]['B']="Porcentaje de ventas del $fini2 al $ffin2"; 
$BOLDrang	['B' . $fila]=3;
$align		['B' . $fila]='C'; 


$fila++;$fila++;

$grid[$fila]['B']="TIENDAS"; 
$grid[$fila]['C']="VENTAS"; 
$grid[$fila]['D']="%"; 
$BOLDrang	['B' . $fila . ':' . 'D' . $fila]=3;
$align		['B' . $fila . ':' . 'D' . $fila]='C'; 



$fila++;

foreach ($datos as $idt => $qty) {
$grid[$fila]['B']=$tiendas2[$idt]; 
$BOLDrang	['B' . $fila]=1;	
	
$grid[$fila]['C']=number_format($qty,2,',','.'); 
$grid[$fila]['D']=number_format(($qty/$tot*100),2,',','.');	

$BOLDrang	['C' . $fila . ':' . 'D' . $fila]=4;
$align		['B' . $fila . ':' . 'D' . $fila]='C'; 
$fila++;
}


$grid[$fila]['B']="TOTAL:"; 
$grid[$fila]['C']=number_format($tot,2,',','.'); 

$BOLDrang	['B' . $fila . ':' . 'D' . $fila]=3;
$align		['B' . $fila . ':' . 'D' . $fila]='C'; 

/*
$BOLDrang	['C' . $fila . ':' . 'S' . $fila]=2;
$align		['B' . $fila . ':' . 'T' . $fila]='C'; 
$crang		['B' . $fila . ':' . 'T' . $fila]=$color;
$BTrang		['B' . $fila . ':' . 'T' . $fila]=1;
*/



$anchos['B']=25;
$anchos['C']=35;
$anchos['D']=18;
$anchos['E']=18;

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
$_SESSION['nomfil']="PorcVentas-$fini2 - $ffin2";
$_SESSION['BOLDrang']=$BOLDrang;
$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);

}else{
$res['ng']=0;	
}


echo json_encode($res);






?>

