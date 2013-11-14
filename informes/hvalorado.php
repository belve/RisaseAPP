<?php
session_start();
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("basics.php");
require_once("../db.php");
require_once("../variables.php");

$debug=0;

$angle=array();
$grid=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();

$options="";
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
$paginas=array();
$fini="";
$ffin="";
$BOLDrang=array();
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$fdesde=$fini; $fhasta=$ffin;
$fini=substr($fini, 6,4) . "-" . substr($fini, 3,2) . "-" . substr($fini, 0,2);
$ffin=substr($ffin, 6,4) . "-" . substr($ffin, 3,2) . "-" . substr($ffin, 0,2);


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







require_once("../functions/listador.php");

$codigosIN="";$codigosIN2="";
if($options){
$queryp= "select id, codbarras, preciocosto, pvp, (stockini + COALESCE((select sum(repo) from reposiciones WHERE ida=articulos.id),0)) as stockini, stock, refprov  from articulos where $options ;";
}else{
$queryp= "select id, codbarras, preciocosto, pvp, (stockini + COALESCE((select sum(repo) from reposiciones WHERE ida=articulos.id),0)) as stockini, stock, refprov  from articulos where congelado=0;";	
}



$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$cd=$row['codbarras'];$cd2=$row['id'];
$refprov=$row['refprov'];
$codigos[$cd]="$cd / $refprov";

$g=substr($cd,0,1);$sg=substr($cd,1,1);$c=substr($cd,4);
$cord[$g][$sg][$c]=$cd;

$vcods[$cd]['pc']=$row['preciocosto']; 	$PC[$cd]=$row['preciocosto'];
$vcods[$cd]['pvp']=$row['pvp'];			
$vcods[$cd]['sti']=$row['stockini'];
$vcods[$cd]['sti_V']=round($row['stockini']*$row['preciocosto'],2);

$vcods[$cd]['stc']=$row['stock'];
$vcods[$cd]['stc_V']=round($row['stock']*$row['preciocosto'],2);
if($vcods[$cd]['sti_V']>0){$vcods[$cd]['stc_V_P']=round(($vcods[$cd]['stc_V']/$vcods[$cd]['sti_V'])*100,2);}else{$vcods[$cd]['stc_V_P']="";};



$codigosIN .=$cd . ",";
$codigosIN2 .=$cd2 . ",";


$vcods[$cd]['vbru']="";
$vcods[$cd]['vbru_V']="";
$vcods[$cd]['valv_V']="";	
$vcods[$cd]['bene_V']="";
$vcods[$cd]['vbru_V_P']="";
$vcods[$cd]['vtda']="";
$vcods[$cd]['vtda_V']="";
$vcods[$cd]['vtda_V_P']="";

}

$codigosIN=substr($codigosIN, 0,-1);
$codigosIN="AND id_articulo IN ($codigosIN)";

$codigosIN2=substr($codigosIN2, 0,-1);
$codigosIN3=$codigosIN2;
$codigosIN2="AND id_articulo IN ($codigosIN2)";


$codv=array();
$queryp= "select id_articulo, sum(cantidad) as cant from ticket_det where (fecha >= '$fini' AND fecha <= '$ffin')
 $codigosIN group by id_articulo;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
$cods2="";
while ($row = $dbnivel->fetchassoc()){
$cd=$row['id_articulo']; $cant=$row['cant'];

$vcods[$cd]['vbru']=$cant;
$vcods[$cd]['vbru_V']=round($cant*$vcods[$cd]['pc'],2); 
if($vcods[$cd]['sti_V']>0){$vcods[$cd]['vbru_V_P']=round(($vcods[$cd]['vbru_V']/$vcods[$cd]['sti_V'])*100,2);}else{$vcods[$cd]['vbru_V_P']="";};

$vcods[$cd]['valv_V']=round($cant*$vcods[$cd]['pvp'],2);$VV[$cd]=$vcods[$cd]['valv_V'];
$vcods[$cd]['bene_V']=round($vcods[$cd]['valv_V'] - $vcods[$cd]['sti_V'],2);$BE[$cd]=$vcods[$cd]['bene_V'];
if($vcods[$cd]['sti']>0){$BU[$cd]=round($vcods[$cd]['bene_V']/$vcods[$cd]['sti'],2);}else{$BU[$cd]="";};
}





$agrupaciones="";
$queryp= "select distinct agrupar from pedidos where ((fecha >= '$fini' AND fecha <= '$ffin') OR tip=1) $codigosIN2 ;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$agrupaciones .=$row['agrupar'] . ",";};
$agrupaciones=substr($agrupaciones, 0,-1);


$queryp= "select id from agrupedidos where id IN ($agrupaciones) AND (estado='T' OR estado='E' OR estado='F') AND ((fecha >= '$fini' AND fecha <= '$ffin') OR tip=1);";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$peds .=$row['id'] . ",";};


$peds=substr($peds, 0,-1);


$queryp= "select (select codbarras from articulos where id=id_articulo) as codbarras, 
sum(cantidad) as cant from pedidos where agrupar in ($peds) $codigosIN2 group by id_articulo;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};$enviados=array();
while ($row = $dbnivel->fetchassoc()){
$cd=$row['codbarras']; $cant=$row['cant'];

$vcods[$cd]['vtda']=$cant;
$vcods[$cd]['vtda_V']=round($cant*$vcods[$cd]['pc'],2);
if($vcods[$cd]['sti_V']>0){$vcods[$cd]['vtda_V_P']=round(($vcods[$cd]['vtda_V']/$vcods[$cd]['sti_V'])*100,2);}else{$vcods[$cd]['vtda_V_P']="";};

		
	
}


$stocks=array();
############ aqui debo sumar lo enviado en fijarstock
$queryp= "select (select codbarras from articulos where id=id_articulo) as codbarras, 
sum(suma) as cant from fij_stock where bd=2 AND (fecha >= '$fini' AND fecha <= '$ffin') $codigosIN2 group by id_articulo;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$cd=$row['codbarras']; $cant=$row['cant'];

$vcods[$cd]['vtda'];
 
if(array_key_exists($cd, $vcods)){
if(array_key_exists('vtda', $vcods[$cd])){				
$vcods[$cd]['vtda']=$vcods[$cd]['vtda']+$cant;		
}else{$vcods[$cd]['vtda']=$cant;};	
}else{$vcods[$cd]['vtda']=$cant;};

$cant=$vcods[$cd]['vtda'];
$vcods[$cd]['vtda_V']=round($cant*$vcods[$cd]['pc'],2);
if($vcods[$cd]['sti_V']>0){$vcods[$cd]['vtda_V_P']=round(($vcods[$cd]['vtda_V']/$vcods[$cd]['sti_V'])*100,2);}else{$vcods[$cd]['vtda_V_P']="";};




}
########################################################







if (!$dbnivel->close()){die($dbnivel->error());};








if($act==1){
$cdg=array();
if(count($cord)>0){
if($actO=='A'){ksort($cord);}else{krsort($cord);} 
foreach ($cord as $gu => $subs) {
	if($actO=='A'){ksort($subs);}else{krsort($subs);} foreach ($subs as $sb => $ccs)	{
		if($actO=='A'){ksort($ccs);}else{krsort($ccs);} foreach ($ccs as $cd => $codbar) {
$cdg[$codbar]=1;
}}}}}


if($act==2){
$cdg=array();
if(count($BU)>0){
if($actO=='A'){asort($BU);}else{arsort($BU);}
foreach ($BU as $codbar => $portc){
$cdg[$codbar]=1;	
}}}


if($act==3){
$cdg=array();
if(count($VV)>0){
if($actO=='A'){asort($VV);}else{arsort($VV);}
foreach ($VV as $codbar => $portc){
$cdg[$codbar]=1;	
}}}

if($act==4){
$cdg=array();
if(count($BE)>0){
if($actO=='A'){asort($BE);}else{arsort($BE);}
foreach ($BE as $codbar => $portc){
$cdg[$codbar]=1;	
}}}


$gridD=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();

$fila=5;$cuenf=0;

$sumSTI=0;$sumSTC=0;$sumVTDA=0;$sumVBRU=0;
$sumSTI_V=0;$sumSTC_V=0;$sumVTDA_V=0;$sumVBRU_V=0;$sumVALV_V=0;$sumBENE_V=0;
if(count($cdg)>0){
foreach ($cdg as $cd => $point) {$fila++;$cuenf++;
if($cuenf >= 8){$cuenf=0;$paginas[$fila+4]=1;}	

$align['A' . $fila . ':' . 'I' . $fila]='C';
$grid[$fila]['B']="COSTE/PVP";
$grid[$fila]['C']="COMPRA"; 
$grid[$fila]['D']="ALMACEN"; 
$grid[$fila]['E']="TIENDAS"; 
$grid[$fila]['F']="BRUTO VEND"; 
$grid[$fila]['G']="VALOR VENTA"; 
$grid[$fila]['H']="BENEFICIO"; 
$grid[$fila]['I']="Bº UNITARIO"; 

$fila++;


$BTrang['A' . $fila . ':' . 'I' . ($fila+3)]=2;
$format['B' . $fila . ':' . 'B' . ($fila+1)]=1;
$format['B' . ($fila+2) . ':' . 'I' . ($fila+2)]=1;
$format['B' . ($fila+3) . ':' . 'I' . ($fila+3)]=2;

$align['B' . $fila . ':' . 'I' . $fila]='C';
$grid[$fila]['A']=$codigos[$cd];
$grid[$fila]['B']=$vcods[$cd]['pc'] . " €";



$fila++;

$align['B' . $fila . ':' . 'I' . $fila]='C';
$crang['A' . $fila . ':' . 'I' . $fila]='C2E0FF';
$grid[$fila]['A']="UNIDADES - PVP";
$grid[$fila]['B']=$vcods[$cd]['pvp'] . " €"; 
$grid[$fila]['C']=$vcods[$cd]['sti']; $sumSTI=$sumSTI+$vcods[$cd]['sti'];
$grid[$fila]['D']=$vcods[$cd]['stc']; $sumSTC=$sumSTC+$vcods[$cd]['stc'];
$grid[$fila]['E']=$vcods[$cd]['vtda'];$sumVTDA=$sumVTDA+$vcods[$cd]['vtda'];
$grid[$fila]['F']=$vcods[$cd]['vbru'];$sumVBRU=$sumVBRU+$vcods[$cd]['vbru'] . " €";

$fila++;

$align['B' . $fila . ':' . 'I' . $fila]='C';
$crang['A' . $fila . ':' . 'I' . $fila]='ADEBAD';
$grid[$fila]['A']="VALORES";
$grid[$fila]['C']=$vcods[$cd]['sti_V']; $sumSTI_V=$sumSTI_V+$vcods[$cd]['sti_V'];
$grid[$fila]['D']=$vcods[$cd]['stc_V']; $sumSTC_V=$sumSTC_V+$vcods[$cd]['stc_V'];
$grid[$fila]['E']=$vcods[$cd]['vtda_V'];$sumVTDA_V=$sumVTDA_V+$vcods[$cd]['vtda_V'];
$grid[$fila]['F']=$vcods[$cd]['vbru_V'] . " €";$sumVBRU_V=$sumVBRU_V+$vcods[$cd]['vbru_V'];
$grid[$fila]['G']=$vcods[$cd]['valv_V'] . " €";$sumVALV_V=$sumVALV_V+$vcods[$cd]['valv_V'];
$grid[$fila]['H']=$vcods[$cd]['bene_V'] . " €";$sumBENE_V=$sumBENE_V+$vcods[$cd]['bene_V'];
$grid[$fila]['I']=round(($vcods[$cd]['bene_V'])/($vcods[$cd]['sti']),2)  . " €";
$fila++;

$align['B' . $fila . ':' . 'I' . $fila]='C';
$crang['A' . $fila . ':' . 'I' . $fila]='FFFF80';
$grid[$fila]['A']="PORCENTAJES";
$grid[$fila]['D']=$vcods[$cd]['stc_V_P'] . " %";
$grid[$fila]['E']=$vcods[$cd]['vtda_V_P'] . " %";
$grid[$fila]['F']=$vcods[$cd]['vbru_V_P'] . " %";


$fila++;

}}
$fila=$fila+5;

###################### totales

$align['A' . $fila . ':' . 'H' . $fila]='C';

$grid[$fila]['B']="COSTE/PVP";
$grid[$fila]['C']="COMPRA"; 
$grid[$fila]['D']="ALMACEN"; 
$grid[$fila]['E']="TIENDAS"; 
$grid[$fila]['F']="BRUTO VEND"; 
$grid[$fila]['G']="VALOR VENTA"; 
$grid[$fila]['H']="BENEFICIO"; 
$grid[$fila]['I']="Bº UNITARIO"; 

$fila++;


$format['B' . ($fila+1) . ':' . 'I' . ($fila+1)]=1;
$format['B' . ($fila+2) . ':' . 'I' . ($fila+2)]=2;

$BTrang['A' . $fila . ':' . 'I' . ($fila+2)]=1;
$align['B' . $fila . ':' . 'I' . $fila]='C';
$crang['A' . $fila . ':' . 'I' . $fila]='C2E0FF';
$grid[$fila]['A']="UNIDADES";

$grid[$fila]['C']=$sumSTI;
$grid[$fila]['D']=$sumSTC;
$grid[$fila]['E']=$sumVTDA;
$grid[$fila]['F']=$sumVBRU  . " €";

$fila++;

$align['B' . $fila . ':' . 'I' . $fila]='C';
$crang['A' . $fila . ':' . 'I' . $fila]='ADEBAD';
$grid[$fila]['A']="VALORES";
$grid[$fila]['C']=$sumSTI_V;
$grid[$fila]['D']=$sumSTC_V;
$grid[$fila]['E']=$sumVTDA_V;
$grid[$fila]['F']=$sumVBRU_V . " €";
$grid[$fila]['G']=$sumVALV_V . " €";
$grid[$fila]['H']=$sumBENE_V . " €";
$grid[$fila]['I']=round($sumBENE_V/$sumSTI_V,2) . " €";

$fila++;


$align['B' . $fila . ':' . 'I' . $fila]='C';
$crang['A' . $fila . ':' . 'I' . $fila]='FFFF80';
$grid[$fila]['A']="PORCENTAJES";
if($sumSTI>0){$grid[$fila]['D']=round(($sumSTC/$sumSTI*100),2) . " %";};
if($sumSTI>0){$grid[$fila]['E']=round(($sumVTDA/$sumSTI*100),2) . " %";};
if($sumSTI>0){$grid[$fila]['F']=round(($sumVBRU/$sumSTI*100),2) . " %";};



$anchos['A']=40;
$anchos['B']=14;
$anchos['C']=14;
$anchos['D']=14;
$anchos['E']=14;
$anchos['F']=14;
$anchos['G']=14;
$anchos['H']=14;
$anchos['I']=14;

$hoy=date('d') . "/" . date('m') . "/" . date('Y');
$grid[1]['A']="FECHA IMPRESION: $hoy";
$grid[1]['B']="GRUPO: $ngrupo";	$Mrang['B1:C1']=1;
$grid[1]['D']="SUBGRUPO: $nsgrupo"; $Mrang['D1:E1']=1;
$grid[1]['F']="COLOR: $ncolor"; 	$Mrang['F1:G1']=1;
$grid[1]['H']="PRECIO: $pvp";	$Mrang['H1:I1']=1;



$grid[2]['A']="PROVEEDOR: $nprov";
$grid[2]['B']="DESDE: $desde";	$Mrang['B2:C2']=1;
$grid[2]['D']="HASTA: $hasta";	$Mrang['D2:E2']=1;
$grid[2]['F']="TEMPORADA: $temporada";$Mrang['F2:G2']=1;

$grid[3]['B']="INTERVALO DE FECHAS              DESDE: $fdesde                 HASTA: $fhasta "; $Mrang['B3:G3']=1;
 
$BTrang['A1:I1']=1;
$BTrang['A2:G2']=1;
$BTrang['B3:G3']=1;




$_SESSION['angle']=$angle;
$_SESSION['cgd'] = $cdg; 
$_SESSION['grid'] = $grid; 
$_SESSION['anchos'] = $anchos;
$_SESSION['align'] = $align;
$_SESSION['crang']=$crang;
$_SESSION['Mrang']=$Mrang;
$_SESSION['BTrang']=$BTrang;
$_SESSION['format']=$format;
$_SESSION['paginas']=$paginas;
$_SESSION['nomfil']="HVValorada";
$_SESSION['BOLDrang']=$BOLDrang;

$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+(count($format)*2);
echo json_encode($res);
?>