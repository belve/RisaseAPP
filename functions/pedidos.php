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

$fecha=date('d') . date('m') . date('y');

$fechaBD=date('Y') . "-" . date('m')  . "-" . date('d');

$hora=date('H') . date('i');

$html="";
if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "delete from pedidos where cantidad=0;";
$dbnivel->query($queryp);


if($agrupar){

if($tip==1){
$idsagrup=array();	
$queryp= "select id_articulo, 
(select id_proveedor from articulos where id=id_articulo) as nprov, 
(select nomcorto from proveedores where id=nprov) as nomcorto 
from pedidos WHERE tip=$tip AND estado='-' AND (agrupar='' or agrupar IS NULL) GROUP BY id_articulo;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
	$agrupaciones[$row['nprov']]=$row['nomcorto'] . "-" . $fecha;
	if(array_key_exists($row['nprov'], $idsagrup)){$idsagrup[$row['nprov']] .=$row['id_articulo'] . ",";}else{$idsagrup[$row['nprov']]=$row['id_articulo'] . ",";};
}


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
		
$idsdonde=$idsagrup[$idpr];	
$idsdonde=substr($idsdonde, 0,-1);
$queryp="update pedidos set agrupar='$idagrup' where id_articulo IN ($idsdonde) AND tip=$tip AND estado='-' AND (agrupar='' or agrupar IS NULL);";	
}
if($tip==2){
$queryp="update pedidos set agrupar='$idagrup' where id_tienda=$idpr AND tip=$tip AND estado='-' AND (agrupar='' or agrupar IS NULL);";	
}
$dbnivel->query($queryp); 


}}
	
}


$queryp= "select id, nombre from agrupedidos where estado='P' AND tip=$tip ORDER BY nombre;";
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
	
$count=0;	$fila=0;$cb=array();
global $dbnivel;

$pendientes=array();$html="";

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "delete from pedidos where cantidad=0;";
$dbnivel->query($queryp);

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

if(count($cb)>0){
ksort($cb);
foreach ($cb as $g => $sgs) {ksort($sgs); foreach ($sgs as $sg => $cods) {ksort($cods); foreach ($cods as $cod => $codb) {
$fila++;	
$html .=linAr($codb,$ref[$codb],$rep[$codb],$fila);	
}}}}



$html .="<INPUT id='maxF' type='hidden' value='$fila'>";

return $html;		
}



function pedipent($tip){
	
global $dbnivel;

$pendientes=array();$html="";$cb=array();

if (!$dbnivel->open()){die($dbnivel->error());};$count=0;

$queryp= "delete from pedidos where cantidad=0;";
$dbnivel->query($queryp);





$duplis=array();
$queryp= "select id_tienda, id_articulo, count(id) as C 
from pedidos where tip=$tip AND estado='-' 
GROUP BY agrupar,id_tienda,id_articulo ORDER BY id_tienda, C desc;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){if($row['C']>1){$duplis[$row['id_tienda']][$row['id_articulo']]=1;};};

if(count($duplis)>0){
		
	foreach ($duplis as $idtien => $dups){ foreach ($dups as $idarticul => $value) {

		$queryp= "select id, cantidad from pedidos where tip=$tip AND estado='-' AND id_tienda=$idtien AND id_articulo=$idarticul;";
		$dbnivel->query($queryp); 
		$qttyb=0;	$idsd=''; $borrr=''; 
		
		while ($row = $dbnivel->fetchassoc()){
		if(!$idsd){ $idsd=$row['id']; }else{ $borrr.=$row['id'] . ','; } 	
		$qttyb=$qttyb + $row['cantidad'];
		}
		$borrr=substr($borrr, 0,-1);
		
		$queryp= "UPDATE pedidos SET cantidad='$qttyb' WHERE id=$idsd;";
		$dbnivel->query($queryp); 
		
		$queryp= "DELETE FROM pedidos WHERE id IN ($borrr) AND id NOT IN ($idsd);";
		$dbnivel->query($queryp); 
	
}}}


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

if(count($cb)>0){
ksort($cb);
foreach ($cb as $g => $sgs) {ksort($sgs); foreach ($sgs as $sg => $cods) {ksort($cods); foreach ($cods as $cod => $codb) {
$fila++;	
$html .=linAr($codb,$ref[$codb],$rep[$codb],$fila);	
}}}}


$html .="<INPUT id='maxF' type='hidden' value='$fila'>";

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
$queryp= "delete from pedidos where cantidad=0;";
$dbnivel->query($queryp);

if($filtroQ){
$queryp= "select id, nombre, estado from agrupedidos where tip=$tip $filtroQ order by estado, nombre;";
}else{
$m=date('m') - 1;
if($m <= 9){$m="0" . $m;};	
$fecham=date('Y') . "-" . $m . "-" . date('d');	
$queryp= "select id, nombre, estado from agrupedidos where tip=$tip AND fecha >= '$fecham' order by estado, nombre;";	
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

$queryp= "delete from pedidos where cantidad=0;";
$dbnivel->query($queryp);
			
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