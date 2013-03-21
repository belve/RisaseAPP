<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

if(($id_proveedor)&&($id_g)&&($id_proveedor)&&($id_s)&&($color)&&($temp)){
	
if (!$dbnivel->open()){die($dbnivel->error());};





$queryp= "select nomcorto from proveedores where id=$id_proveedor;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$abrePro=$row['nomcorto'];};

$queryp= "select id from subgrupos where id_grupo=$id_g AND clave=$id_s;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$idsubgrupo=$row['id'];};

$queryp= "select max(id) as id from articulos";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$idc=$row['id'] +1;};

$queryp= "select max(codigo) as ultimo from articulos where id_subgrupo=$idsubgrupo and id_color=$color;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$ultimo=$row['ultimo'];};$ultimo++;


$codparabarras=$ultimo;
if(strlen($ultimo)==1){$codparabarras="000" . $ultimo;};
if(strlen($ultimo)==2){$codparabarras="00" . $ultimo;};
if(strlen($ultimo)==3){$codparabarras="0" . $ultimo;};

$refprov=$abrePro . "-" . $repro;
$color=$color*1;
if($color < 10){$color="0" . $color;};
$codbarras=$id_g . $id_s . $color . $codparabarras;
$precioC=str_replace(',','.',$precioC);
$pvp=str_replace(',','.',$pvp);
$precioN= ($precioC - ($precioC * $dto1) - ($precioC *$dto2)) * ('1.' . $iva);
$precioF= ($precioC - ($precioC * $dto1) - ($precioC *$dto2)) * 1.20;

$queryp= "INSERT INTO articulos 
(id,id_proveedor,id_subgrupo,id_color,codigo,refprov,stock,uniminimas,codbarras,temporada,preciocosto,precioneto,preciofran,pvp,congelado,stockini) 
values 
($idc,$id_proveedor,$idsubgrupo,$color,$ultimo,'$refprov',$cantidad,'$alarma',$codbarras,'$temp','$precioC','$precioN','$precioF','$pvp',0,'$alarma')";


$dbnivel->query($queryp);




if (!$dbnivel->close()){die($dbnivel->error());};

$valores[$codbarras]=$codbarras;
echo json_encode($valores);
}