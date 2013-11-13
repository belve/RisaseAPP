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
$paginas=array();$grid=array();
$fini="";
$ffin="";
$format=array(); $BOLDrang=array();

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};




$peds="";$cods="";$codigos=array();$vendidos=array();$cord=array();

if (!$dbnivel->open()){die($dbnivel->error());};
$nprov="";
if($id_proveedor){
$queryp= "select nomcorto from proveedores where id=$id_proveedor;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nprov=$row['nomcorto'];};
}


$ngrupo="";
if($id_grupo){
$queryp= "select nombre from grupos where id=$id_grupo;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$ngrupo=$row['nombre'];};
}
$nsgrupo="";
if($id_subgrupo){
$queryp= "select nombre from subgrupos where id=$id_subgrupo;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nsgrupo=$row['nombre'];};
}

$ncolor="";
if($id_color){
$queryp= "select nombre from colores where id=$id_color;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$ncolor=$row['nombre'];};
}



foreach ($tiendas as $idt => $nom) {
$vendidos[$idt]=array();
$stocks[$idt]=array();	
}





if($cong){$conge=" AND congelado=0";}else{$conge="";}

require_once("../functions/listador.php");

$codigosIN="";$codigosIN2="";
if($options){
$queryp= "select id, codbarras, refprov, stock, stockini, temporada, congelado, pvp, precioneto from articulos where $options$conge;";

}else{
$queryp= "select id, codbarras, refprov, stock, stockini, temporada, congelado, pvp, precioneto from articulos where congelado=0;";	
}

$equicon[0]='NO';
$equicon[1]='SI';

$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$cd=$row['codbarras'];
$cd2=$row['id'];

$datos[$cd]['refprov']=$row['refprov'];
$datos[$cd]['stock']=$row['stock'];
$datos[$cd]['stockini']=$row['stockini'];
$datos[$cd]['temporada']=$row['temporada'];
$datos[$cd]['congelado']=$equicon[$row['congelado']];
$datos[$cd]['pvp']=$row['pvp'];
$datos[$cd]['precioneto']=$row['precioneto'];


$g=substr($cd,0,1);$sg=substr($cd,1,1);$c=substr($cd,4);
$cord[$g][$sg][$c]=$cd;



}


$queryp= "select (select nombre from grupos where id=id_grupo) as G, nombre as SG, id_grupo, clave from subgrupos;";	
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$grupos[$row['id_grupo']]=$row['G'];	
$subgrupos[$row['id_grupo'] . $row['clave']]=$row['SG'];	
}


if (!$dbnivel->close()){die($dbnivel->error());};





$act=1;$actO='A';


if($act==1){
$cdg=array();
if(count($cord)>0){
if($actO=='A'){ksort($cord);}else{krsort($cord);} 
foreach ($cord as $gu => $subs) {
	if($actO=='A'){ksort($subs);}else{krsort($subs);} foreach ($subs as $sb => $ccs)	{
		if($actO=='A'){ksort($ccs);}else{krsort($ccs);} foreach ($ccs as $cd => $codbar) {
$cdg[$codbar]=1;
}}}}}


$angle=array();
$gridD=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();

$fila=0;$cuenf=0; $first=1; $lg=""; $lsg="";

if(count($cdg)>0){
foreach ($cdg as $cd => $point) {$fila++; //$cuenf++;
//if($cuenf >= 8){$cuenf=0;$paginas[$fila+4]=1;}	

if ($first) {
$grid[$fila]['A']="CODIGO";
$grid[$fila]['D']="REF. PROV."; 
$grid[$fila]['E']="STOCK"; 
$grid[$fila]['F']="INICIAL"; 
$grid[$fila]['G']="TEMP"; 
$grid[$fila]['H']="CONG"; 
$grid[$fila]['I']="PVP"; 
$grid[$fila]['J']="NETO"; 

$Mrang['A' . $fila . ':' . 'C' . $fila]=1;
$align['A' . $fila . ':' . 'J' . $fila]='C';
$BOLDrang['A' . $fila . ':' . 'J' . $fila]=1;
$BTrang['A' . $fila . ':' . 'J' . $fila]=1;
$fila++;$first=0;

}


//$BTrang['A' . $fila . ':' . 'I' . ($fila+3)]=2;
//$format['B' . $fila . ':' . 'B' . ($fila+1)]=1;
//$format['B' . ($fila+2) . ':' . 'I' . ($fila+2)]=1;
//$format['B' . ($fila+3) . ':' . 'I' . ($fila+3)]=2;

//$align['B' . $fila . ':' . 'I' . $fila]='C';

$g=substr($cd,0,1);
$sg=substr($cd,0,2);


//if($g!=$lg){
	//$grid[$fila]['A']=$grupos[$g]; $lg=$g;
	//$align['A' . $fila . ':' . 'I' . $fila]='C';
	//$BOLDrang['A' . $fila . ':' . 'I' . $fila]=1;
	//}

if(!array_key_exists($sg, $subgrupos)){$subgrupos[$sg]="GENERICO";};
$sng=$subgrupos[$sg];

if($sg!=$lsg){$fila++;
	 $grid[$fila]['A']=$grupos[$g] . "/" . $sng; 
	 $lsg=$sg; 
	 $align['A' . $fila . ':' . 'I' . $fila]='C';
	 $BOLDrang['A' . $fila . ':' . 'I' . $fila]=1;
	 $Mrang['A' . $fila . ':' . 'D' . $fila]=1;
	 $crang['A' . $fila]='A3ECFF';
	 $fila++;}


$align['A' . $fila . ':' . 'B' . $fila]='C';
$align['D' . $fila]='L';
$align['E' . $fila . ':' . 'I' . $fila]='C';

$cgs=substr($cd,0,2); 		$cgs=str_pad($cgs, 2, '0', STR_PAD_LEFT);
$color=substr($cd,2,2); 	$color=str_pad($color, 2, '0', STR_PAD_LEFT);
$codigosim=substr($cd,4);  	$codigosim=str_pad($codigosim, (strlen($cd)-4), '0', STR_PAD_LEFT);

$grid[$fila]['A']=$cgs; $grid[$fila]['B']=$color; $grid[$fila]['C']=$codigosim;

$format["A$fila"]='cer2';
$format["B$fila"]='cer2';
$format["C$fila"]='cer' . strlen($codigosim);


$grid[$fila]['D']=$datos[$cd]['refprov']; 
$grid[$fila]['E']=$datos[$cd]['stock']; 
$grid[$fila]['F']=$datos[$cd]['stockini']; 
$grid[$fila]['G']=$datos[$cd]['temporada']; 
$grid[$fila]['H']=$datos[$cd]['congelado']; 
$grid[$fila]['I']=$datos[$cd]['pvp']; 
$grid[$fila]['J']=$datos[$cd]['precioneto']; 
$BTrang['A' . $fila . ':' . 'J' . $fila]=1;
$BOLDrang['A' . $fila . ':' . 'J' . $fila]=2;



}}




$anchos['A']=5;
$anchos['B']=5;
$anchos['C']=8;

$anchos['D']=48;
$anchos['E']=11;
$anchos['F']=11;
$anchos['G']=11;
$anchos['H']=11;
$anchos['I']=11;
$anchos['J']=11;

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
$_SESSION['nomfil']="Inventario-" . date('Y') . date('m') . date('d');

$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);
echo json_encode($res);
?>