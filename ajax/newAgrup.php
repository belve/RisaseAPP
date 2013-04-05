<?php


foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");
$idagrup="";

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp="SELECT id FROM agrupedidos WHERE nombre='$nom';";	
$dbnivel->query($queryp);	
while ($row = $dbnivel->fetchassoc()){$idagrup=$row['id'];};


if(!$idagrup){
$queryp="INSERT INTO agrupedidos (nombre,tip,estado) values ('$nom',$tip,'P')";	
$dbnivel->query($queryp);	

$queryp="SELECT LAST_INSERT_ID() as id;";	
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$idagrup=$row['id'];};
$valores['id']=$idagrup;
}else{
$valores['error']='Ya existe una agrupación con ese nombre.';
}



if (!$dbnivel->close()){die($dbnivel->error());};



echo json_encode($valores);


?>