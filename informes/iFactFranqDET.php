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

$eqtp[1]="R:";
$eqtp[2]="P:";


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
$queryp= "select id_tienda, tip, (SELECT codbarras from articulos where id=id_articulo) as cb, 
CONCAT( (substring((SELECT codbarras from articulos where id=id_articulo),1,2)),(substring((SELECT codbarras from articulos where id=id_articulo),5)) ) as GS, 
sum(cantidad) as qty , 
(select preciocosto from articulos where id=id_articulo) as impu, 
sum(cantidad * (select preciocosto from articulos where id=id_articulo)) as impt 
from pedidos where id_tienda IN ($ttss) AND fecha >= '$fini' AND fecha <= '$ffin' GROUP BY id_tienda, tip, id_articulo order by id_tienda, tip, GS;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){


$datos[$row['id_tienda']][$row['tip']][$row['cb']]['qty']=$row['qty'];
$datos[$row['id_tienda']][$row['tip']][$row['cb']]['impu']=$row['impu'];
$datos[$row['id_tienda']][$row['tip']][$row['cb']]['impt']=$row['impt'];	

};



if (!$dbnivel->close()){die($dbnivel->error());};


$cols[1]['B']='B';
$cols[1]['C']='C';
$cols[1]['D']='D';
$cols[1]['E']='E';

$cols[2]['B']='G';
$cols[2]['C']='H';
$cols[2]['D']='I';
$cols[2]['E']='J';

$angle=array();
$grid=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();$p=1;$sumas=array();


$fila=1; $lT=""; $lTi=""; $count=1;


foreach ($datos as $idt => $tips){
$totQ=0; $totI=0; $cc=1;
####### cabecera tienda	
	
$grid[$fila]['B']=$tiendasN[$idt];	
$Mrang[$cols[1]['B'] . $fila . ":" . $cols[2]['E'] . $fila]=1;
$align[$cols[$cc]['B'] . $fila]='C';

$BOLDrang	[$cols[$cc]['B'] . $fila]=1;
 $ffila=$fila+3; $fila++;$fila++;	$count=1;
 foreach ($tips as $tip => $cbs) {
	############ cabecera tipo	 		
	$grid[$fila][$cols[$cc]['B']]=$eqtip[$tip];	
	$Mrang[$cols[$cc]['B'] . $fila . ":" . $cols[$cc]['E'] . $fila]=1;
	$align[$cols[$cc]['B'] . $fila ]='C';
	$BOLDrang	[$cols[$cc]['B'] . $fila ]=1;
	$fila++; $count++;	 	

	foreach ($cbs as $cb => $vals) {
	
	 if($count>40){
		if($cc==1){$cc=2; $fila=$ffila; $count=1; }else{$cc=1; $paginas[$fila]=1; $fila++; $count=1; $ffila=$fila; };			  
	  }
			
			
			$grid[$fila][$cols[$cc]['B']]=$eqtp[$tip] . $cb;
			$grid[$fila][$cols[$cc]['C']]=$vals['qty'];	$totQ=$totQ+$vals['qty'];	
			
			$grid[$fila][$cols[$cc]['D']]=number_format($vals['impu'],2,',','.');
			$align[$cols[$cc]['D'] . $fila]='R';
			
			$grid[$fila][$cols[$cc]['E']]=number_format($vals['impt'],2,',','.');	$totI=$totI+$vals['impt'];
			$align[$cols[$cc]['E'] . $fila]='R';
			
			$BOLDrang	[$cols[$cc]['B'] . $fila . ":" . $cols[$cc]['E'] . $fila]=2;
			
			$fila++;$count++;
	
}}

$fila++;$count++;
$fila=$ffila+40;
$grid[$fila][$cols[$cc]['B']]='TOTAL:';
$grid[$fila][$cols[$cc]['C']]=$totQ;							$align[$cols[$cc]['C'] . $fila]='R';
$grid[$fila][$cols[$cc]['E']]=number_format($totI,2,',','.');	$align[$cols[$cc]['E'] . $fila]='R';
$BOLDrang	[$cols[$cc]['B'] . $fila . ":" . $cols[$cc]['E'] . $fila]=1;
$paginas[$fila]=1;
$fila++;$count++;
}

$anchos['A']=1;

$anchos['B']=18;
$anchos['C']=9;
$anchos['D']=12;
$anchos['E']=12;

$anchos['F']=5;

$anchos['G']=18;
$anchos['H']=9;
$anchos['I']=12;
$anchos['J']=12;





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
$res['ng']=(count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format))*2;

}else{
$res['ng']=0;	
}


echo json_encode($res);






?>

