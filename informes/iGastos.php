<?php
session_start();
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("basics.php");
require_once("../db.php");
require_once("../variables.php");

$debug=0;



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
$BE=array();
$paginas=array();$grid=array();$cord=array();$datos=array();
$fini="";
$ffin="";
$format=array(); $BOLDrang=array(); $tipo=""; $temp="";$ccn=0;$total=0;
$ttss="";$rot=0; $dev=0; 
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};




if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id_subgrupo, 
(SELECT nombre from subgrupos where id=id_subgrupo )as nsg, 
(SELECT id_grupo from subgrupos where id=id_subgrupo ) as idg, 
(SELECT clave from subgrupos where id=id_subgrupo ) as idsg, 
(SELECT nombre from grupos where id=idg ) as ng, 
(sum(stockini * preciocosto) +  COALESCE((select sum(repo * articulos.preciocosto) from reposiciones WHERE temp='$temp' AND ida=articulos.id),0) ) as SI, sum(stock * preciocosto) as SS 
from articulos WHERE temporada='$temp'  AND stockini > 0  GROUP BY id_subgrupo ORDER BY idg,idsg; ";	
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";}; 
echo $dbnivel->error();
while ($row = $dbnivel->fetchassoc()){
$g=$row['idg']; $sg=$g . $row['idsg'];  
$datos[$g][$sg]['C']=$row['SI'];	
$datos[$g][$sg]['S']=$row['SS'];

}

$queryp= "select (select nombre from grupos where id=id_grupo) as G, nombre as SG, id_grupo, clave from subgrupos;";	
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$grupos[$row['id_grupo']]=$row['G'];	
$subgrupos[$row['id_grupo'] . $row['clave']]=$row['SG'];	
}





if (!$dbnivel->close()){die($dbnivel->error());};


$cols[1]['A']='B';
$cols[1]['B']='C';
$cols[1]['C']='D';

$cols[2]['A']='F';
$cols[2]['B']='G';
$cols[2]['C']='H';

$cols[3]['A']='J';
$cols[3]['B']='K';
$cols[3]['C']='L';



$act=1;$actO='A';




$angle=array();
$gridD=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();


$titu['C']="LISTADO PRECIO DE COSTO DE MERCANCÍA";
$titu['S']="LISTADO PRECIO DE COSTO DE MERCANCÍA EN ALMACÉN";

$fila=1;
$Mrang		['A' . $fila . ':' . 'H' . $fila]=1;
$align		['A' . $fila . ':' . 'H' . $fila]='C';
$grid[$fila]['A']=$titu[$tipo]; 
$BOLDrang	['A' . $fila ]=1;
$fila++; $fila++;


$fila=3;$cuenf=0; $first=1; $lg=""; $lsg="";$lidt=""; $c=1; $count=0; $lastfil=$fila;$sum=0; $prim=0;

if(count($datos)>0){
foreach ($datos as $g => $cdgs) {
$grups=count($cdgs);
foreach ($cdgs as $sg => $dat) {

$A=$cols[$c]['A'];
$B=$cols[$c]['B'];
$C=$cols[$c]['C'];






if($g!=$lg){
$subc=0;	
   
	
$lg=$g; 

$ccn=$count+$grups+2;
if($ccn > 45){
$first=1;	$count=0; 
if ($c < 2){$c++; $fila=$lastfil;}else{ $c=1; $paginas[$fila]=1; $lastfil=$fila;};
}

$A=$cols[$c]['A'];
$B=$cols[$c]['B'];
$C=$cols[$c]['C'];


	 $grid[$fila][$A]=$grupos[$g];
	 $BOLDrang	[$A . $fila ]=1;
	 $Mrang		[$A . $fila . ':' . $B . $fila]=1;
	 $align		[$A . $fila . ':' . $B . $fila]='L';
	 $fila++; $count++;
}

if(!array_key_exists($sg, $subgrupos)){$subgrupos[$sg]="GENERICO";};
$sng=$subgrupos[$sg];


	 $grid[$fila][$B]=$sng; 
	 $align		[$B . $fila]='L';
	 
	 $grid[$fila][$C]=number_format($dat[$tipo],2,',','.'); $sum=$sum+$dat[$tipo]; $total=$total+$dat[$tipo];
	 $align		[$C . $fila]='R';
	 $BOLDrang	[$A . $fila . ':' . $C . $fila]=2; $subc++;
	 $fila++; $count++;
	 
	if($subc==$grups){
	$grid[$fila][$B]='Total'; 
	$align		[$B . $fila]='L';
	$BOLDrang	[$A . $fila . ':' . $C . $fila]=1;
	$grid[$fila][$C]=number_format($sum,2,',','.');
	$align		[$C . $fila]='R'; $sum=0;
	$fila++; $count++;	$fila++; $count++;	
	 }







}}



$fila=48;

$grid[$fila]['G']='TOTAL:'; 
$align		['G' . $fila]='L';

$grid[$fila]['H']=number_format($total,2,',','.'); 
$align		['H' . $fila]='R';
$BOLDrang	['G' . $fila . ':' . 'H' . $fila]=1;


$anchos['A']=10;
$anchos['B']=4;
$anchos['C']=22;
$anchos['D']=15;
$anchos['E']=15;
$anchos['F']=4;
$anchos['G']=22;
$anchos['H']=15;
$anchos['I']=15;


$_SESSION['BOLDrang']=$BOLDrang;
$_SESSION['angle']=$angle;
$_SESSION['grid'] = $grid; 
$_SESSION['anchos'] = $anchos;
$_SESSION['align'] = $align;
$_SESSION['crang']=$crang;
$_SESSION['Mrang']=$Mrang;
$_SESSION['BTrang']=$BTrang;
$_SESSION['format']=$format;
$_SESSION['paginas']=$paginas;
$_SESSION['nomfil']="gastos-mercancia-" . $temp;

$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);

}else{
$res['ng']=0;	
}


echo json_encode($res);
?>