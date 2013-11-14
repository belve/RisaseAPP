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
$paginas=array();$grid=array();$cord=array();
$fini="";
$ffin="";
$format=array(); $BOLDrang=array();
$ttss="";$rot=0; $dev=0; 
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$fini=substr($fini, 6,4) . "-" . substr($fini, 3,2) . "-" . substr($fini, 0,2);
$ffin=substr($ffin, 6,4) . "-" . substr($ffin, 3,2) . "-" . substr($ffin, 0,2);



$mod="";
if(($rot==1)&&($dev==1)){
$mod="WHERE (modo='R' OR modo='D')";	
}

if(($rot==1)&&($dev==0)){
$mod="WHERE modo='R'";	
}

if(($rot==0)&&($dev==1)){
$mod="WHERE modo='D'";	
}



$tie="";
if($ttss){
$ttss=substr($ttss, 0,-1);
$tie=" AND id_tienda IN ($ttss)";		
}

if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id_tienda, codbarras, modo, sum(qty) as qty from roturas $mod $tie AND (fecha >= '$fini' AND fecha <= '$ffin') GROUP BY id_tienda, codbarras, modo;";	
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbnivel->error();
while ($row = $dbnivel->fetchassoc()){
	
$cd=$row['codbarras'];
$idt=$row['id_tienda'];
$m=$row['modo'];

$datos[$idt][$cd][$m]=$row['qty'];

$g=substr($cd,0,1);$sg=substr($cd,1,1);$c=substr($cd,4);
$cord[$idt][$g][$sg][$c]=$cd;



}

$queryp= "select (select nombre from grupos where id=id_grupo) as G, nombre as SG, id_grupo, clave from subgrupos;";	
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$grupos[$row['id_grupo']]=$row['G'];	
$subgrupos[$row['id_grupo'] . $row['clave']]=$row['SG'];	
}





if (!$dbnivel->close()){die($dbnivel->error());};


$cols[1]['A']='A';
$cols[1]['B']='B';
$cols[1]['C']='C';

$cols[2]['A']='E';
$cols[2]['B']='F';
$cols[2]['C']='G';

$cols[3]['A']='I';
$cols[3]['B']='J';
$cols[3]['C']='K';



$act=1;$actO='A';


if($act==1){
$cdg=array();
if(count($cord)>0){
ksort($cord);
foreach ($cord as $idt => $codss) {
if($actO=='A'){ksort($codss);}else{krsort($codss);} 
foreach ($codss as $gu => $subs) {
	if($actO=='A'){ksort($subs);}else{krsort($subs);} foreach ($subs as $sb => $ccs)	{
		if($actO=='A'){ksort($ccs);}else{krsort($ccs);} foreach ($ccs as $cd => $codbar) {
$cdg[$idt][$codbar]=1;
}}}}}}



$gridD=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();
$angle=array();

$fila=0;$cuenf=0; $first=1; $lg=""; $lsg="";$lidt=""; $c=1; $count=0; $lastfil=$fila;

if(count($cdg)>0){
foreach ($cdg as $idt => $cdgs) {
foreach ($cdgs as $cd => $point) {
//if($cuenf >= 8){$cuenf=0;$paginas[$fila+4]=1;}	



if($count > 49){
$lg=""; $lsg=""; $first=1;	$count=0; $lidt="";
if ($c < 3){$c++; $fila=$lastfil;}else{ $c=1; $paginas[$fila]=1; $lastfil=$fila;};
}




$fila++; $count++;

$A=$cols[$c]['A'];
$B=$cols[$c]['B'];
$C=$cols[$c]['C'];

if ($first) {
$grid[$fila][$A]="CODIGO";
$grid[$fila][$B]="R"; 
$grid[$fila][$C]="D";
 

$align		[$A . $fila . ':' . $C . $fila]='C';
$BOLDrang	[$A . $fila . ':' . $C . $fila]=1;
$BTrang		[$A . $fila . ':' . $C . $fila]=1;
$fila++;$count++; $first=0;

}


if($lidt!=$idt){$lidt=$idt; $lg=""; $lsg=""; $fila++; $count++;
$align		[$A . $fila . ':' . $C . $fila]='C';
$BOLDrang	[$A . $fila . ':' . $C . $fila]=1;
$Mrang		[$A . $fila . ':' . $C . $fila]=1;
$crang		[$A . $fila . ':' . $C . $fila]='8AE65C'; 
$grid[$fila][$A]=$tiendasN[$idt];

}






$g=substr($cd,0,1);
$sg=substr($cd,0,2);



if(!array_key_exists($sg, $subgrupos)){$subgrupos[$sg]="GENERICO";};

$sng=$grupos[$g] . " / " . $subgrupos[$sg];

if($sg!=$lsg){
	 $fila++; $count++; $lsg=$sg; 
	 $grid[$fila][$A]=$sng; 
	 $align		[$A . $fila . ':' . $C . $fila]='C';
	 $BOLDrang	[$A . $fila . ':' . $C . $fila]=1;
	 $Mrang		[$A . $fila . ':' . $C . $fila]=1;
	 $fila++; $count++;
}



$align[$A . $fila]='C';
$align[$B . $fila]='C';
$align[$C . $fila]='C';

$grid[$fila][$A]=$cd;

$R="";$D="";
if(array_key_exists('R', $datos[$idt][$cd])){$R=$datos[$idt][$cd]['R'];};
if(array_key_exists('D', $datos[$idt][$cd])){$D=$datos[$idt][$cd]['D'];};
$grid[$fila][$B]=$R;
$grid[$fila][$C]=$D;

$BTrang		[$A . $fila . ':' . $C . $fila]=1;
$BOLDrang	[$A . $fila . ':' . $C . $fila]=2;



}}

$anchos['A']=18;
$anchos['B']=10;
$anchos['C']=10;
$anchos['D']=4;
$anchos['E']=18;
$anchos['F']=10;
$anchos['G']=10;
$anchos['H']=4;
$anchos['I']=18;
$anchos['J']=10;
$anchos['K']=10;

$_SESSION['angle']=$angle;
$_SESSION['BOLDrang']=$BOLDrang;
$_SESSION['cgd'] = $cdg; 
$_SESSION['grid'] = $grid; 
$_SESSION['anchos'] = $anchos;
$_SESSION['align'] = $align;
$_SESSION['crang']=$crang;
$_SESSION['Mrang']=$Mrang;
$_SESSION['BTrang']=$BTrang;
$_SESSION['format']=$format;
$_SESSION['paginas']=$paginas;
$_SESSION['nomfil']="Devoluciones-" . date('Y') . date('m') . date('d');

$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);

}else{
$res['ng']=0;	
}


echo json_encode($res);
?>