<?php
set_time_limit(0);
session_start();


require_once("../db.php");
require_once("../variables.php");

$debug=1;




foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$fini="2013-08-01";
$ffin="2013-08-10";



$peds="";$cods="";$codigos=array();$vendidos=array();$cord="";


foreach ($tiendas as $idt => $nom) {
$vendidos[$idt]=array();
$stocks[$idt]=array();	
}



if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select id from agrupedidos where (estado='T' OR estado='E' OR estado='F') AND (fecha >= '$fini' AND fecha <= '$ffin');";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$peds .=$row['id'] . ",";};
$peds=substr($peds, 0,-1);


$queryp= "select (select codbarras from articulos where id=id_articulo) as codbarras, 
(select refprov from articulos where id=id_articulo) as refprov, 
id_tienda, sum(cantidad) as cant from pedidos where agrupar in ($peds) group by id_articulo, id_tienda;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
	
$cd=$row['codbarras']; $idt=$row['id_tienda']; $cant=$row['cant']; $refprov=$row['refprov'];
$cods .=$cd . ","; 

if(!array_key_exists($cd, $codigos)){
$tiends[$idt]=1;	
$codigos[$cd]="$cd / $refprov";
$g=substr($cd,0,1);$sg=substr($cd,1,1);$c=substr($cd,4);
$cord[$g][$sg][$c]=$cd;
}


$enviados[$cd][$idt]=$cant;
}

$cods=substr($cods, 0,-1);


$queryp= "select id_articulo, id_tienda, sum(cantidad) as cant, sum(importe * cantidad) as imp, importe from ticket_det where (fecha >= '$fini' AND fecha <= '$ffin')
 AND id_articulo IN ($cods) group by id_articulo, id_tienda;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$cd=$row['id_articulo']; $idt=$row['id_tienda']; $cant=$row['cant']; $imp=$row['imp'];
$cods .=$cd . ",";
$vendidos[$idt][$cd]['c']=$cant;
$vendidos[$idt][$cd]['i']=$imp;

}



if (!$dbnivel->close()){die($dbnivel->error());};


$dbBAK=new DB('192.168.1.11','edu','admin','tpv_backup');
if (!$dbBAK->open()){die($dbBAK->error());};

foreach ($tiends as $idt => $value) {
	$queryp= "select cod, stock from stocklocal_$idt where cod IN ($cods);";
	$dbBAK->query($queryp); if($debug){echo "$queryp \n\n";};
	while ($row = $dbBAK->fetchassoc()){
	$cd=$row['cod']; $cant=$row['stock']; 
	$stocks[$idt][$cd]=$cant;
	}
}


if (!$dbBAK->close()){die($dbBAK->error());};




$_SESSION['cord'] = $cord;
$_SESSION['codigos'] = $codigos;
$_SESSION['enviados'] = $enviados;
$_SESSION['vendidos'] = $vendidos;
$_SESSION['stocks'] = $stocks;
$_SESSION['tiendas'] = $tiendas;
if($debug==1){print_r($_SESSION);};

?>