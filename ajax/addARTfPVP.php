<?php
$id_proveedor="";$id_grupo="";$id_subgrupo="";$id_color="";$codigo="";$pvp="";$desde="";$hasta="";$temporada="";$hago="";
$yalistados="";
$detalles="";
$comentarios="";
$fijCHK=0;
$ord=1;
$tab=1;
$arts=array();
$vals=array();
$fijos	=array();
$pvps= array();
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$options="";$forsync="";
$codigos="";
require_once("../functions/listador.php");
    if($yalistados){$options .=" OR id IN ($yalistados)"; };
	
	if($options){
	$queryp= "select id, codbarras, pvp from articulos where $options;"; 
	}elseif($fijCHK){
	$queryp= "select distinct id_articulo as id, (select codbarras from articulos where id=id_articulo) as codbarras, (select pvp from articulos where id=id_articulo) as pvp from fij_pvp;";	
	}
	
	$dbnivel->query($queryp); 
	while ($row = $dbnivel->fetchassoc()){
		
	$cd=$row['codbarras']; $id_articulo=$row['id'];
		
	$pvps[$id_articulo]=$row['pvp'];
	
	$codigos .=$id_articulo . ",";
	
	$g=substr($cd,0,1); $s=substr($cd,1,1);$c=substr($cd,4);
	$arts[$g][$s][$c][$id_articulo]=$cd;	
	}

$codigos=substr($codigos, 0,-1);

	$queryp= "select id_articulo, id_tienda, pvp from fij_pvp where id_articulo IN ($codigos);"; 
	$dbnivel->query($queryp);
	while ($row = $dbnivel->fetchassoc()){
	$fijos[$row['id_tienda']][$row['id_articulo']]=$row['pvp'];	
	}
		



if (!$dbnivel->close()){die($dbnivel->error());};

if(count($arts)>0){
ksort($arts);
foreach ($arts as $g => $sub) {ksort($sub); foreach ($sub as $s => $cods) {ksort($cods); foreach ($cods as $co => $art) { foreach ($art as $id => $codbarras) {
	$vals['i_' . $id]=$id;
    $vals['c_' . $id]=$codbarras;
    $vals['p_' . $id]=$pvps[$id];
	
	
foreach ($tiendas as $idt => $nomt) {
	if(array_key_exists($idt, $fijos)){$arts=$fijos[$idt];
			
	if(array_key_exists($id, $arts)){$cant=$arts[$id];}else{$cant=0;}	;
	$vals['t_' . $idt . "|" . $id]=$cant;
	
	}else{
	$vals['t_' . $idt . "|" . $id]=0;	
	}
	
}
		
	
	
}}}}}

#print_r($vals);

echo json_encode($vals);