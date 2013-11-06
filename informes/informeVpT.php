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
		
	$grus2[$gru][$qty]=$id;
	$grus3[$id]=$gru;
	$vend[$id]=$qty;
	$tven[$id]=$idt;
	}

if (!$dbn->close()){die($dbn->error());};





$grid=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();



$col[1]['A']='B';
$col[1]['B']='C';
$col[1]['C']='D';
$col[1]['D']='E';

$col[2]['A']='G';
$col[2]['B']='H';
$col[2]['C']='I';
$col[2]['D']='J';




if($id){






if ($act==1){if($actO=='A'){ksort($grus2);}else{krsort($grus2);};
foreach ($grus2 as $grup => $ngrus) {krsort($ngrus); foreach ($ngrus as $q => $idd) {
$grus[$idd]=$grup;	
}}
$d=$grus;
};

if ($act==3){if($actO=='A'){asort($vend);}else{arsort($vend);};$d=$vend;$grus=$grus3;	};



$fila=0;$lg="";
$lf=0;
$count=0;

$c=1;
foreach ($d as $id => $value) {
$gru=$grus[$id]; $vt=$vend[$id]; $idt=$tven[$id]; $p1=($vt/$sum[$gru])*100; $p2=($vt/$stot)*100; 

if($count > 40) {
	if($c==1){ $fila=$fila-41; $c=2; $lg=""; $count=0;}else{$paginas[$fila]=1; $fila++; $c=1;  $lg="";$count=0; }
}

if($gru!=$lg){

	
			if($lg){	
			$grid[$fila][$col[$c]['A']]='TOTAL';		
			$grid[$fila][$col[$c]['B']]=number_format($sum[$lg],2,',','.');
			$grid[$fila][$col[$c]['D']]=number_format(($sum[$lg]/$stot*100),2,',','.');		
			$BOLDrang	[$col[$c]['A'] . $fila. ':' . $col[$c]['D'] . $fila]=1;
			$align		[$col[$c]['A'] . $fila. ':' . $col[$c]['D'] . $fila]='C'; 
			$BTrang		[$col[$c]['A'] . $fila. ':' . $col[$c]['D'] . $fila]=1;
			$fila++;$count++;
			}


$fila++;$count++;
$lg=$gru;
$Mrang[$col[$c]['A'] . $fila . ":" . $col[$c]['D'] .$fila]=1;
$grid[$fila][$col[$c]['A']]=$nomSG[$gru]; 

$BOLDrang	[$col[$c]['A'] . $fila]=1;
$align		[$col[$c]['A'] . $fila]='C'; 
$BTrang		[$col[$c]['A'] . $fila. ':' . $col[$c]['D'] . $fila]=1;
$fila++;$count++;	

		
$grid[$fila][$col[$c]['B']]='VENTA';
$grid[$fila][$col[$c]['C']]='%SUB';
$grid[$fila][$col[$c]['D']]='%TOT';		
$BOLDrang	[$col[$c]['A'] . $fila. ':' . $col[$c]['D'] . $fila]=1;
$align		[$col[$c]['A'] . $fila. ':' . $col[$c]['D'] . $fila]='C'; 
$BTrang		[$col[$c]['A'] . $fila. ':' . $col[$c]['D'] . $fila]=1;
$fila++;$count++;
	
}


$grid[$fila][$col[$c]['A']]=$tiendas2[$idt]; 
$BOLDrang	[$col[$c]['A'] . $fila]=1;

$grid[$fila][$col[$c]['B']]=number_format($vt,2,',','.');
$grid[$fila][$col[$c]['C']]=number_format($p1,2,',','.');
$grid[$fila][$col[$c]['D']]=number_format($p2,2,',','.');	
$BOLDrang	[$col[$c]['B'] . $fila . ':' . $col[$c]['D'] . $fila]=2;
$align		[$col[$c]['A'] . $fila . ':' . $col[$c]['D'] . $fila]='C'; 
$BTrang		[$col[$c]['A'] . $fila . ':' . $col[$c]['D'] . $fila]=1;

$fila++;$count++;
}



$grid[$fila][$col[$c]['A']]='TOTAL';		
$grid[$fila][$col[$c]['B']]=number_format($sum[$lg],2,',','.');
$grid[$fila][$col[$c]['D']]=number_format(($sum[$lg]/$stot*100),2,',','.');		
$BOLDrang	[$col[$c]['A'] . $fila. ':' . $col[$c]['D'] . $fila]=1;
$align		[$col[$c]['A'] . $fila. ':' . $col[$c]['D'] . $fila]='C'; 
$BTrang		[$col[$c]['A'] . $fila. ':' . $col[$c]['D'] . $fila]=1;


}




$anchos['B']=10;
$anchos['C']=15;
$anchos['D']=10;
$anchos['E']=10;
$anchos['F']=5;
$anchos['G']=10;
$anchos['H']=15;
$anchos['I']=10;
$anchos['J']=10;



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
$_SESSION['nomfil']="VentasporTienda";
$_SESSION['BOLDrang']=$BOLDrang;
$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);

}else{
$res['ng']=0;	
}


echo json_encode($res);


?>