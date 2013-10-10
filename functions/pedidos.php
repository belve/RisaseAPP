<?php

function linAr($idart,$ref,$rep,$fila){
$html= "
<div class='pedPen' id='$idart' onclick='selART($idart);'><input type='hidden' id='I$idart' value='$fila'><input type='hidden' id='F$fila' value='$idart'>
<div class='pedPen_ART'>$ref</div>
<div class='pedPen_REP'>$rep</div>
</div>
";	

return $html;	
}



function agrupaciones($tip,$agrupar){
	
global $dbnivel;$idagrup="";

$fecha=date('d') . date('m') . date('Y');

$fechaBD=date('Y') . "-" . date('m')  . "-" . date('d');

$hora=date('H') . date('i');

$html="";
if (!$dbnivel->open()){die($dbnivel->error());};


if($agrupar){

if($tip==1){
$queryp= "SELECT distinct(prov) as nprov, 
(select nomcorto from proveedores where id=nprov) as nomcorto 
from pedidos WHERE tip=$tip AND estado='-' AND (agrupar='' or agrupar IS NULL) GROUP BY id_articulo ORDER BY prov, grupo, subgrupo, codigo;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$agrupaciones[$row['nprov']]=$row['nomcorto'] . "-" . $fecha;}
}

if($tip==2){
$queryp= "SELECT distinct(id_tienda) as idt, 
(select id_tienda from tiendas where id=idt) as ntie, 
(select orden from tiendas where id=idt) as orden  
from pedidos WHERE tip=$tip AND estado='-' AND (agrupar='' or agrupar IS NULL) GROUP BY id_tienda ORDER BY orden;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$agrupaciones[$row['idt']]=$row['ntie'] . "-" . $fecha . $hora;}
}

if(count($agrupaciones)>0){foreach($agrupaciones as $idpr => $agrupp){
	
$idagrup="";	
$queryp="SELECT id, nombre, estado FROM agrupedidos WHERE nombre like '$agrupp%' ORDER BY nombre;";	
$dbnivel->query($queryp);$version=0;	
while ($row = $dbnivel->fetchassoc()){
	$nombre	=$row['nombre'];
	$idagrup=$row['id'];	
	$estado =$row['estado'];
		
	if (($estado=='T')||($estado=='F')){
	$datos=explode('-', $nombre);		
	if(array_key_exists(2, $datos)){$version=$datos[2];}else{$version=1;};	
	$version++;
	}
	
	
	}
if($version){$idagrup=""; $agrupp=$agrupp . "-" . $version;};
	
	
if(!$idagrup){
$queryp="INSERT INTO agrupedidos (nombre,tip,fecha) values ('$agrupp',$tip,'$fechaBD');";
$dbnivel->query($queryp);
$queryp="SELECT LAST_INSERT_ID() as id;";	
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$idagrup=$row['id'];};
}

if($tip==1){
$queryp="update pedidos set agrupar='$idagrup' where prov=$idpr AND tip=$tip AND estado='-' AND (agrupar='' or agrupar IS NULL);";	
}
if($tip==2){
$queryp="update pedidos set agrupar='$idagrup' where id_tienda=$idpr AND tip=$tip AND estado='-' AND (agrupar='' or agrupar IS NULL);";	
}
$dbnivel->query($queryp); 


}}
	
}


$queryp= "select id, nombre from agrupedidos where estado='P' AND tip=$tip;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
$idagrupado=$row['id'];$nomagrup=$row['nombre'];
$html.= "
<div class='agrup' id='$idagrupado' onclick='selectAgrup($idagrupado,$tip)'>$nomagrup
<div class='iconos trash' onclick='borra_agru($idagrupado,$tip)'></div>
</div>
";	
}



if (!$dbnivel->close()){die($dbnivel->error());};

	
	
	
return $html;	
	
}


function listagrup($tip,$id){
	
$count=0;	$fila=0;
global $dbnivel;

$pendientes=array();$html="";

if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "SELECT id_articulo, sum(cantidad) as rep, 
(select codbarras from articulos where articulos.id=pedidos.id_articulo) as codbarras, 
(select refprov from articulos where articulos.id=pedidos.id_articulo) as refprov 
from pedidos WHERE agrupar='$id' GROUP BY id_articulo;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
	
$idart=$row['id_articulo'];
$codb=$row['codbarras'];	
$ref[$idart]=$codb . " / " . $row['refprov'];
$rep[$idart]=$row['rep'];


$g=substr($codb, 0,1); $sg=substr($codb, 1,1); $cod=substr($codb,4);
$cb[$g][$sg][$cod]=$idart;

}


if (!$dbnivel->close()){die($dbnivel->error());};

ksort($cb);
foreach ($cb as $g => $sgs) {ksort($sgs); foreach ($sgs as $sg => $cods) {ksort($cods); foreach ($cods as $cod => $codb) {
$fila++;	
$html .=linAr($codb,$ref[$codb],$rep[$codb],$fila);	
}}}



$html .="<INPUT id='maxF' type='hidden' value='$count'>";

return $html;		
}



function pedipent($tip){
	
global $dbnivel;

$pendientes=array();$html="";

if (!$dbnivel->open()){die($dbnivel->error());};$count=0;
$queryp= "SELECT id_articulo, sum(cantidad) as rep, 
(select codbarras from articulos where articulos.id=pedidos.id_articulo) as codbarras, 
(select refprov from articulos where articulos.id=pedidos.id_articulo) as refprov 
from pedidos WHERE tip=$tip AND estado='-' AND (agrupar='' or agrupar IS NULL) GROUP BY id_articulo ORDER BY grupo, subgrupo, codigo;";
$dbnivel->query($queryp);$fila=0; 
while ($row = $dbnivel->fetchassoc()){
	
$idart=$row['id_articulo'];
$codb=$row['codbarras'];	
$ref[$idart]=$codb . " / " . $row['refprov'];
$rep[$idart]=$row['rep'];


$g=substr($codb, 0,1); $sg=substr($codb, 1,1); $cod=substr($codb,4);
$cb[$g][$sg][$cod]=$idart;

	
};


ksort($cb);
foreach ($cb as $g => $sgs) {ksort($sgs); foreach ($sgs as $sg => $cods) {ksort($cods); foreach ($cods as $cod => $codb) {
$fila++;	
$html .=linAr($codb,$ref[$codb],$rep[$codb],$fila);	
}}}


$html .="<INPUT id='maxF' type='hidden' value='$count'>";

if (!$dbnivel->close()){die($dbnivel->error());};

return $html;	
}



function agrup_estado($tip,$est,$filtro){
global $dbnivel;$html['P']=array();$html['A']=array();$html['T']=array();$html['F']=array();

$html['filasP']=0;$html['filasA']=0;$html['filasT']=0;$html['filasF']=0;


$equiestado['P']='1';
$equiestado['A']='2';
$equiestado['T']='3';
$equiestado['E']='3';
$equiestado['F']='4';


if($est=='E'){$est='T';};

if($filtro){
if($est=='T'){
		
$filtroQ="AND (estado='T' or estado='E') AND nombre LIKE '%$filtro%' ";	
	
}else{
		
$filtroQ="AND estado='$est' AND nombre LIKE '%$filtro%' ";	

}}else{
$filtroQ="";	
}



if (!$dbnivel->open()){die($dbnivel->error());};	


if($filtroQ){
$queryp= "select id, nombre, estado from agrupedidos where tip=$tip $filtroQ order by estado;";
}else{
$m=date('m') - 1;
if($m <= 9){$m="0" . $m;};	
$fecham=date('Y') . "-" . $m . "-" . date('d');	
$queryp= "select id, nombre, estado from agrupedidos where tip=$tip AND fecha >= '$fecham' order by estado, fecha;";	
}



$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	
$idagrupado=$row['id'];$nomagrup=$row['nombre'];

$estado=$row['estado'];
if($estado=="E"){$estado="T";};

$html['filas' . $estado]++;$count=$html['filas' . $estado];

$estado2=$equiestado[$estado];
$html[$estado][].="<div class='agrup_V2' id='$idagrupado' onclick='selV2agrup(\"$idagrupado|$estado2\")'><div style='width:110px;'>$nomagrup</div></div>";	

}



if (!$dbnivel->close()){die($dbnivel->error());};

	

return $html;	
		
	
}


function change_estado($idag,$newest){

global $dbnivel;$restostock=array();

if (!$dbnivel->open()){die($dbnivel->error());};

$equiestado['P']='-';
$equiestado['A']='A';
$equiestado['T']='T';
$equiestado['E']='T';
$equiestado['F']='F';

$est=$equiestado[$newest];
$queryp= "UPDATE pedidos SET estado='$est' where agrupar=$idag;";
$dbnivel->query($queryp);$fila=0; 
$queryp= "UPDATE agrupedidos SET estado='$newest' where id=$idag;";
$dbnivel->query($queryp);$fila=0; 


########## aqui hay q actualizar stocks en caso de enviado a tienda

if($est=='T'){
			
$queryp= "SELECT id_articulo, cantidad FROM pedidos where agrupar=$idag;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	if(!array_key_exists($row['id_articulo'], $restostock)){
	$restostock[$row['id_articulo']]=$row['cantidad'];
	}else{
	$restostock[$row['id_articulo']]=$restostock[$row['id_articulo']] + $row['cantidad'];	
	}
}		
	
print_r($restostock);

if(count($restostock)>0){foreach ($restostock as $idaact => $qty){
$queryp= "UPDATE articulos SET stock=stock - $qty WHERE id=$idaact;";
$dbnivel->query($queryp);	
}}

}

$valores=array();
return $valores;


	
}

?>