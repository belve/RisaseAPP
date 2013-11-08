<?php
session_start();
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("basics.php");
require_once("../db.php");
require_once("../variables.php");

$debug=0;


$eqtip[1]="REPARTOS";
$eqtip[2]="PEDIDOS";

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
$queryp= "select id_tienda, tip, agrupar, 
(select nombre from agrupedidos where id=agrupar) as nomag, fecha, 
sum(cantidad) as qty, 
sum(cantidad * (select preciocosto from articulos where id=id_articulo)) as imp 
from pedidos where id_tienda IN ($ttss) AND fecha >= '$fini' AND fecha <= '$ffin' GROUP BY id_tienda, tip, agrupar order by id_tienda, tip, fecha;
";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){


$datos[$row['id_tienda']][$row['tip']][$row['fecha']][$row['nomag']]['qty']=$row['qty'];
$datos[$row['id_tienda']][$row['tip']][$row['fecha']][$row['nomag']]['imp']=$row['imp'];
	

};



if (!$dbnivel->close()){die($dbnivel->error());};



$angle=array();
$grid=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();$p=1;$sumas=array();


$fila=1; $lT=""; $lTi="";
foreach ($datos as $idt => $tips){
$totQ=0; $totI=0;
####### cabecera tienda		
$grid[$fila]['B']=$tiendasN[$idt];	
$Mrang["B$fila:E$fila"]=1;
$align["B$fila"]='C';
$BOLDrang	['B' . $fila]=1;
$fila++;$fila++;		
 foreach ($tips as $tip => $dates) {
	############ cabecera tipo	 		
	$grid[$fila]['B']=$eqtip[$tip];	
	$Mrang["B$fila:E$fila"]=1;
	$align["B$fila"]='C';
	$BOLDrang	['B' . $fila]=1;
	$fila++;	 	
	 	 foreach ($dates as $fecha => $noms) { foreach ($noms as $nomag => $vals) {

			$grid[$fila]['B']=$fecha;
			$grid[$fila]['C']=$nomag;		
			
			$grid[$fila]['D']=$vals['qty'];	$totQ=$totQ+$vals['qty'];
			$align["D$fila"]='R';
			
			$grid[$fila]['E']=number_format($vals['imp'],2,',','.');	$totI=$totI+$vals['imp'];
			$align["E$fila"]='R';
			
			$BOLDrang	['B' . $fila . ':' . 'E' . $fila]=2;
			
			$fila++;
	
}}}

$fila++;
$grid[$fila]['B']='TOTAL:';
$grid[$fila]['D']=$totQ;							$align["D$fila"]='R';
$grid[$fila]['E']=number_format($totI,2,',','.');	$align["E$fila"]='R';
$BOLDrang	['B' . $fila . ':' . 'E' . $fila]=1;
$paginas[$fila]=1;
$fila++;
}


$anchos['B']=15;
$anchos['C']=35;
$anchos['D']=15;
$anchos['E']=15;


if(count($grid)>0){

$_SESSION['angle']=$angle;
$_SESSION['BOLDrang']=$BOLDrang;
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

