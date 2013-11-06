<?php
session_start();
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("basics.php");
require_once("../db.php");
require_once("../variables.php");

$debug=0;



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
$paginas=array();
$format=array();
$BOLDrang=array();
$fini="";
$ffin="";

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$fdesde=$fini; $fhasta=$ffin;
$fini=substr($fini, 6,4) . "-" . substr($fini, 3,2) . "-" . substr($fini, 0,2);
$ffin=substr($ffin, 6,4) . "-" . substr($ffin, 3,2) . "-" . substr($ffin, 0,2);


$peds="";$cods="";$codigos=array();$vendidos=array();$cord=array();

if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id, orden, id_tienda, nombre, franquicia from tiendas";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$idttt=$row['id'];$orden=$row['orden'];$nidtienda=$row['id_tienda'];$f=$row['franquicia'];
$tiendas2[$idttt]=$nidtienda;
}


$queryp= "select id_grupo, clave, (select nombre from grupos where id=id_grupo) as ng, nombre as nsg from subgrupos;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$grupi=$row['id_grupo'] . $row['clave'];
$nomSG[$grupi]=$row['ng'] . "/" . $row['nsg'];
}





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

$codigosIN="";
if($options){
$queryp= "select id, codbarras from articulos where $options;";
}else{
$queryp= "select id, codbarras from articulos where congelado=0;";
}	
		
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$id_articulo=$row['codbarras'];
$codigosIN .=$id_articulo . ",";
}
$codigosIN=substr($codigosIN, 0,-1);
$codigosIN="AND id_articulo IN ($codigosIN)";

$sum=array();

if($risase){$db='risasa';}else{$db='risase';};
$dbn=new DB('192.168.1.11','edu','admin',$db);

if (!$dbn->open()){die($dbn->error());};
$stot=0;
$queryp= "select g, sg, id_tienda, sum(importe * cantidad) as qty from ticket_det where
 fecha >= '$fini' AND fecha <= '$ffin' $codigosIN GROUP BY g, sg, id_tienda ORDER BY g, sg DESC; ";	
$dbn->query($queryp);
if($debug){echo "$queryp \n\n";};
echo $dbn->error();$id=0;
while ($row = $dbn->fetchassoc()){$id++;
	$g=$row['g']; $sg=$row['sg']; $idt=$row['id_tienda']; $qty=$row['qty'];
	
	$gru=$g . $sg;
	if(array_key_exists($gru, $sum)){$sum[$gru]=$sum[$gru]+$qty;}else{$sum[$gru]=$qty;}; $stot=$stot+$qty;
		
	$grus[$id]=$gru;
	$vend[$id]=$qty;
	$tven[$id]=$idt;
	}

if (!$dbn->close()){die($dbn->error());};


if ($act==1){if($actO=='A'){asort($grus);}else{arsort($grus);};$d=$grus;};
if ($act==3){if($actO=='A'){asort($vend);}else{arsort($vend);};$d=$vend;};



$grid=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();

$fila=0;$lg="";
foreach ($d as $id => $value) {$fila++;
$gru=$grus[$id]; $vt=$vend[$id]; $idt=$tven[$id]; $p1=($vt/$sum[$gru])*100; $p2=($vt/$stot)*100; 


if($gru!=$lg){
$lg=$gru;
$Mrang["A$fila:D$fila"]=1;
$grid[$fila]['A']=$nomSG[$gru]; 

$BOLDrang	['A' . $fila]=1;
$align		['A' . $fila]='C'; 
$BTrang		['A' . $fila]=1;

$fila++;		
}


$grid[$fila]['A']=$tiendas2[$idt]; 
$BOLDrang	['A' . $fila]=1;

$grid[$fila]['B']=number_format($vt,2,',','.');
$grid[$fila]['C']=number_format($p1,2,',','.');
$grid[$fila]['D']=number_format($p2,2,',','.');	
$BOLDrang	['B' . $fila . ':' . 'D' . $fila]=2;
$align		['A' . $fila . ':' . 'D' . $fila]='C'; 
$BTrang		['A' . $fila . ':' . 'D' . $fila]=1;
}






$anchos['A']=10;
$anchos['B']=15;
$anchos['C']=10;
$anchos['D']=10;
$anchos['E']=10;

if(count($grid)>0){

$_SESSION['BOLDrang']=$BOLDrang;
$_SESSION['grid'] = $grid; 
$_SESSION['anchos'] = $anchos;
$_SESSION['align'] = $align;
$_SESSION['crang']=$crang;
$_SESSION['Mrang']=$Mrang;
$_SESSION['BTrang']=$BTrang;
$_SESSION['format']=$format;
$_SESSION['paginas']=$paginas;
$_SESSION['nomfil']="PocentVentas";
$_SESSION['BOLDrang']=$BOLDrang;
$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);

}else{
$res['ng']=0;	
}


echo json_encode($res);


?>