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
$tiens=explode(',',$ttss);

$resumen=array();


$porcen=$porcen*1;
if($porcen < 10){$porcen="0" . $porcen;};
$porcen="0." . $porcen;

if($i<=2){
$db='risase';
$dbn=new DB('192.168.1.11','edu','admin',$db);
if (!$dbn->open()){die($dbn->error());};	
$queryp= "select codbarras, preciocosto from articulos;";
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
while ($row = $dbn->fetchassoc()){$pcostos[$row['codbarras']]=$row['preciocosto'];};

$queryp= "select id_grupo, clave, (select nombre from grupos where id=id_grupo) as g, nombre from subgrupos;";
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
while ($row = $dbn->fetchassoc()){
	
$subg[$row['id_grupo'] . $row['clave']]	=$row['g'] . "/" . $row['nombre'];
}




if (!$dbn->close()){die($dbn->error());};
	
	
$db='tpv_backup';
$dbn=new DB('192.168.1.11','edu','admin',$db);
if (!$dbn->open()){die($dbn->error());};


foreach ($tiens as $key => $idt) {
$idttt=$tiendasN[$idt];
$queryp= "
select 
cod, 
substring(cod,1,1) as G, 
substring(cod,2,1) as SG,  
stock, 
substring(cod,5) as codigo 
from stocklocal_$idt where stock > 0 AND cod NOT LIKE ('_0009999')  ORDER BY substring(cod,1,1) ASC, substring(cod,2,1) ASC, CONVERT(substring(cod,5),UNSIGNED INTEGER) ASC;
";	
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
$stockT=0;
$valorT=0;
$valorAT=0;

while ($row = $dbn->fetchassoc()){
$cod=$row['cod']; $stock=$row['stock']; $valor=$stock * $pcostos[$cod]; $valorA=$valor - ($valor * $porcen); 

if(array_key_exists($row['G'] . $row['SG'], $subg)){
$G=$subg[$row['G'] . $row['SG']];
}else{
$G="SUB: " . $row['G'] . $row['SG'];	
}
$datos[$idttt][$cod]['s']=$stock;
$datos[$idttt][$cod]['v']=$valor;
$datos[$idttt][$cod]['va']=$valorA;
$datos[$idttt][$cod]['G']=$G;


if(!array_key_exists($idttt, $resumen)){$resumen[$idttt]=array();}
if(!array_key_exists($G, $resumen[$idttt])){
$resumen[$idttt][$G]['s']=0;
$resumen[$idttt][$G]['v']=0;
$resumen[$idttt][$G]['va']=0;
$resumen[$idttt][$G]['G']=0;	
}

$resumen[$idttt][$G]['s']=$resumen[$idttt][$G]['s']+$stock;
$resumen[$idttt][$G]['v']=$resumen[$idttt][$G]['v']+$valor;
$resumen[$idttt][$G]['va']=$resumen[$idttt][$G]['va']+$valorA;
$resumen[$idttt][$G]['G']=$G;






}
}

if (!$dbn->close()){die($dbn->error());};
}





if($i>2){
$db='risase';
$dbn=new DB('192.168.1.11','edu','admin',$db);
if (!$dbn->open()){die($dbn->error());};
$queryp= "
select 
codbarras, 
(select nombre from grupos where id=substring(codbarras,1,1) ) as G, 
(select nombre from subgrupos where id=id_subgrupo) as SG, 
stock, codigo, 
(preciocosto * stock) as valor, 
((preciocosto * stock)- (preciocosto * stock * $porcen) ) as valorA
 from articulos where stock > 0 AND codbarras NOT LIKE ('_0009999')  ORDER BY substring(codbarras,1,1) ASC, substring(codbarras,2,1) ASC, codigo ASC;
";	
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
$stockT=0;
$valorT=0;
$valorAT=0;

while ($row = $dbn->fetchassoc()){
$cod=$row['codbarras']; $stock=$row['stock']; $valor=$row['valor']; $valorA=$row['valorA']; $G=$row['G'] . "/" . $row['SG'];

$datos['ALMACEN'][$cod]['s']=$stock;
$datos['ALMACEN'][$cod]['v']=$valor;
$datos['ALMACEN'][$cod]['va']=$valorA;
$datos['ALMACEN'][$cod]['G']=$G;


if(!array_key_exists('ALMACEN', $resumen)){$resumen['ALMACEN']=array();}
if(!array_key_exists($G, $resumen['ALMACEN'])){
$resumen['ALMACEN'][$G]['s']=0;
$resumen['ALMACEN'][$G]['v']=0;
$resumen['ALMACEN'][$G]['va']=0;
$resumen['ALMACEN'][$G]['G']=0;	
}

$resumen['ALMACEN'][$G]['s']=$resumen['ALMACEN'][$G]['s']+$stock;
$resumen['ALMACEN'][$G]['v']=$resumen['ALMACEN'][$G]['v']+$valor;
$resumen['ALMACEN'][$G]['va']=$resumen['ALMACEN'][$G]['va']+$valorA;
$resumen['ALMACEN'][$G]['G']=$G;






}


if (!$dbn->close()){die($dbn->error());};
}





$angle=array();
$grid=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();$p=1;$sumas=array();
$fila=0; $first=1;$cont=0;$liniF=0;
$ltien="";
$lG="";

$cols[1]['A']="A";
$cols[1]['B']="B";
$cols[1]['C']="C";
$cols[1]['D']="D";
$cols[1]['E']="E";

$cols[2]['A']="F";
$cols[2]['B']="G";
$cols[2]['C']="H";
$cols[2]['D']="I";
$cols[2]['E']="J";


$anchos['A']=18;
$anchos['B']=10;
$anchos['C']=10;
$anchos['D']=10;

$anchos['E']=4;

$anchos['F']=18;
$anchos['G']=10;
$anchos['H']=10;
$anchos['I']=10;

if($i==3){$datos=$resumen;$anchos['A']=26;$anchos['F']=26;};
if($i==1){$datos=$resumen;$anchos['A']=26;$anchos['F']=26;};
if(($i==1)||($i==3)){$cm=1;}else{$cm=2;};



$c=1;
$nodo=1;

$fila=$liniF+3;
$liniF=1;
if(count($datos)>0){
foreach ($datos as $tien => $valst) { foreach ($valst as $codb => $values) {$G=$values['G'];


if($ltien != $tien){

if(!$first){	
	
if($c==1){$liniF=$fila;
$cont=0;$fila++;$fila++;
$paginas[$fila-3]=1;
$grid[$fila-2][$cols[$c]['A']]=$tien; $lG="";

$grid[$fila-1][$cols[$c]['B']]='Stock'; 
$grid[$fila-1][$cols[$c]['C']]='Valor'; 
$grid[$fila-1][$cols[$c]['D']]='V Est';  


$Mrang[$cols[1]['A'] . ($fila-2) . ":" . $cols[$cm]['D'] . ($fila-2)]=1;
$align[$cols[1]['A'] . ($fila-2)]="C";
		
}else{	
$cont=0;
$fila=$liniF+2; $c=1;
$paginas[$fila-3]=1;

$grid[$fila-2][$cols[$c]['A']]=$tien; $lG="";

$grid[$fila-1][$cols[$c]['B']]='Stock'; 
$grid[$fila-1][$cols[$c]['C']]='Valor'; 
$grid[$fila-1][$cols[$c]['D']]='V Est';


$Mrang[$cols[1]['A'] . ($fila-2) . ":" . $cols[$cm]['D'] . ($fila-2)]=1;
$align[$cols[1]['A'] . ($fila-2)]="C";	
}

}else{

$grid[$fila-2][$cols[$c]['A']]=$tien; $lG="";

$grid[$fila-1][$cols[$c]['B']]='Stock'; 
$grid[$fila-1][$cols[$c]['C']]='Valor'; 
$grid[$fila-1][$cols[$c]['D']]='V Est';


$Mrang[$cols[1]['A'] . ($fila-2) . ":" . $cols[$cm]['D'] . ($fila-2)]=1;
$align[$cols[1]['A'] . ($fila-2)]="C";
	
}

}


######
if($cont > 80){
	
if($c==1){$fila2=$fila;$lG="";
$fila=$liniF+2; $c=2;
$liniF=$fila2;


$grid[$fila-1][$cols[$c]['B']]='Stock'; 
$grid[$fila-1][$cols[$c]['C']]='Valor'; 
$grid[$fila-1][$cols[$c]['D']]='V Est';

}else{

$fila=$liniF+2; $c=1;
$paginas[$fila-3]=1;
$grid[$fila-2][$cols[$c]['A']]=$tien; $lG="";

$grid[$fila-1][$cols[$c]['B']]='Stock'; 
$grid[$fila-1][$cols[$c]['C']]='Valor'; 
$grid[$fila-1][$cols[$c]['D']]='V Est';


$Mrang[$cols[1]['A'] . ($fila-2) . ":" . $cols[$cm]['D'] . ($fila-2)]=1;
$align[$cols[1]['A'] . ($fila-2)]="C";

}
$cont=0;

}else{

}
##########


####### grupo
if($G!=$lG){


if(!is_numeric($codb)){$codb=$G;}else{
	
$Mrang[$cols[$c]['A'] . $fila . ":" . $cols[$c]['D'] . $fila]=1;		
$grid[$fila][$cols[$c]['A']]=$G;	
$lG=$G; $fila++;$cont++;
}
 	

}
#############


$grid[$fila][$cols[$c]['A']]=$codb; 	
$grid[$fila][$cols[$c]['B']]=$values['s']; 		
$grid[$fila][$cols[$c]['C']]=$values['v']; 
$grid[$fila][$cols[$c]['D']]=$values['va']; 	
$fila++;$cont++;

$first=0;$ltien = $tien;	
}}}


$format['defSize']=10;
$format['defALign']=1;

if($i==1){$nombre="Tiendas-Simple-";};
if($i==2){$nombre="Tiendas-Detalle-";};
if($i==3){$nombre="Almacen-Simple-";};
if($i==4){$nombre="Almacen-Detalle-";};
$hoy=date('Y') . date('m') . date('d');

if(count($grid)>0){

$_SESSION['angle']=$angle;
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
$_SESSION['nomfil']=$nombre . $hoy;
$_SESSION['BOLDrang']=$BOLDrang;
$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);

}else{
$res['ng']=0;	
}


echo json_encode($res);






?>

