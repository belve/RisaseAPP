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
$format=array(); $BOLDrang=array(); $tipo=""; $temp="";$ccn=0;$total=0;
$ttss="";$rot=0; $dev=0; 
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$ttss=substr($ttss, 0,-1);
$frqcia=1;
$fini=substr($fini, 6,4) . "-" . substr($fini, 3,2) . "-" . substr($fini, 0,2);
$ffin=substr($ffin, 6,4) . "-" . substr($ffin, 3,2) . "-" . substr($ffin, 0,2);



/*
if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id, orden, (select id from tiendas where tiendas.id_tienda=empleados.id_tienda) as id_tienda, CONCAT_WS(' ', nombre, apellido1, apellido2) as nom, orden from empleados order by id_tienda, orden ASC;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$count++;
$ord=$row['orden'];
if($ord==0){$ord=100;};
$empsn[$row['id_tienda']][$ord][$row['id']]=$row['nom'];
};



if (!$dbnivel->close()){die($dbnivel->error());};

*/



if($risase){$db='risasa';}else{$db='risase';};
$dbn=new DB('192.168.1.11','edu','admin',$db);

if (!$dbn->open()){die($dbn->error());};
$queryp="SELECT id_tienda, count(*) as nt, sum(importe) as sd, sum( (importe/(100 - descuento) )*100 ) as SSD, (sum(descuento)/count(*)) as dm from tickets 
where descuento > 0 AND fecha >= '$fini' AND fecha <= '$ffin' AND id_tienda IN ($ttss) GROUP BY id_tienda;";

$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
while ($row = $dbn->fetchassoc()){
$idt=$row['id_tienda']; $nt=$row['nt']; $sd=$row['sd']; $SSD=$row['SSD'];	$dm=$row['dm'];

$datos[$idt]['nt']=$nt;
$datos[$idt]['sd']=$sd;
$datos[$idt]['SSD']=$SSD;
$datos[$idt]['dm']=$dm;

}




if (!$dbn->close()){die($dbn->error());};


$grid=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();$p=1;$sumas=array();
$angle=array();

$fila=1;


$anchos['A']=12;
$anchos['B']=21;
$anchos['C']=21;
$anchos['D']=26;
$anchos['E']=24;

$grid[$fila]['A']='TIENDA';		
$grid[$fila]['B']='Nº TICKETS';		
$grid[$fila]['C']='SUM IMPORTES';	
$grid[$fila]['D']='TOT DESCONTADO';	
$grid[$fila]['E']='DESCUENTO MED';	
$BOLDrang	['A' . $fila . ':E' . $fila]=1;
$align		['A' . $fila . ':E' . $fila]='C';


foreach ($datos as $idt => $dat) {$fila++;

$grid[$fila]['A']=$tiendas[$idt];		
$grid[$fila]['B']=$dat['nt'];		
$grid[$fila]['C']=number_format($dat['sd'],2,',','.');	
$grid[$fila]['D']=number_format(($dat['SSD'] - $dat['sd']),2,',','.');	
$grid[$fila]['E']=number_format($dat['dm'],2,',','.') . "%";	

$BOLDrang	['A' . $fila]=1;
$BOLDrang	['B' . $fila . ':E' . $fila]=2;
$align		['A' . $fila . ':E' . $fila]='C';
$BTrang		['A' . $fila . ':E' . $fila]=1;
}



if(count($datos)>0){

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
$_SESSION['nomfil']="DescuentoTiendas";
$_SESSION['BOLDrang']=$BOLDrang;
$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);

}else{
$res['ng']=0;	
}


echo json_encode($res);






?>

