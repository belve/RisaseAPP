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

$fecha=date('Y') . date('m') . date('d');
$html="";
if (!$dbnivel->open()){die($dbnivel->error());};


if($agrupar){

$queryp= "SELECT distinct(prov) as nprov, 
(select nomcorto from proveedores where id=nprov) as nomcorto 
from pedidos WHERE tip=$tip AND estado='-' GROUP BY id_articulo ORDER BY prov, fecha, grupo, subgrupo, codigo;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$agrupaciones[$row['nprov']]=$row['nomcorto'] . "-" . $fecha;}

if(count($agrupaciones)>0){foreach($agrupaciones as $idpr => $agrupp){
	
$idagrup="";	
$queryp="SELECT id FROM agrupedidos WHERE nombre='$agrupp';";	
$dbnivel->query($queryp);	
while ($row = $dbnivel->fetchassoc()){$idagrup=$row['id'];};	

if(!$idagrup){
$queryp="INSERT INTO agrupedidos (nombre,tip) values ('$agrupp',$tip);";
$dbnivel->query($queryp);
$queryp="SELECT LAST_INSERT_ID() as id;";	
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$idagrup=$row['id'];};
}

$queryp="update pedidos set agrupar='$idagrup' where prov=$idpr AND tip=$tip AND estado='-';";	
$dbnivel->query($queryp); 


}}
	
}


$queryp= "select id, nombre from agrupedidos where estado='P' AND tip=$tip;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
$idagrupado=$row['id'];$nomagrup=$row['nombre'];
$html.= "
<div class='agrup' id='$idagrupado' onclick='selectAgrup($idagrupado,$tip)'><input type='text' value='$nomagrup' class='agrupados' onchange='modiAgrup(this.value)'></div>
";	
}



if (!$dbnivel->close()){die($dbnivel->error());};

	
	
	
return $html;	
	
}


function listagrup($tip,$id){
	
	
global $dbnivel;

$pendientes=array();$html="";

if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "SELECT id_articulo, sum(cantidad) as rep, 
(select codbarras from articulos where articulos.id=pedidos.id_articulo) as codbarras, 
(select refprov from articulos where articulos.id=pedidos.id_articulo) as refprov 
from pedidos WHERE tip=$tip AND estado='-' AND agrupar='$id' GROUP BY id_articulo ORDER BY prov, fecha;";
$dbnivel->query($queryp); $fila=0;
while ($row = $dbnivel->fetchassoc()){
$ref=$row['codbarras'] . " / " . $row['refprov'];
$rep=$row['rep'];
$idart=$row['id_articulo'];$fila++;


$html .=linAr($idart,$ref,$rep,$fila);



	
};



if (!$dbnivel->close()){die($dbnivel->error());};

return $html;		
	
	
}



function pedipent($tip){
	
global $dbnivel;

$pendientes=array();$html="";

if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "SELECT id_articulo, sum(cantidad) as rep, 
(select codbarras from articulos where articulos.id=pedidos.id_articulo) as codbarras, 
(select refprov from articulos where articulos.id=pedidos.id_articulo) as refprov 
from pedidos WHERE tip=$tip AND estado='-' AND (agrupar='' or agrupar IS NULL) GROUP BY id_articulo ORDER BY prov, fecha;";
$dbnivel->query($queryp);$fila=0; 
while ($row = $dbnivel->fetchassoc()){
$ref=$row['codbarras'] . " / " . $row['refprov'];
$rep=$row['rep'];
$idart=$row['id_articulo'];$fila++;

$html .=linAr($idart,$ref,$rep,$fila);

	
};



if (!$dbnivel->close()){die($dbnivel->error());};

return $html;	
}



function agrup_estado($tip){
global $dbnivel;$html['P']=array();$html['A']=array();$html['T']=array();$html['F']=array();

$html['filasP']=0;$html['filasA']=0;$html['filasT']=0;$html['filasF']=0;

if (!$dbnivel->open()){die($dbnivel->error());};	
$queryp= "select id, nombre, estado from agrupedidos where tip=$tip order by estado;";
$dbnivel->query($queryp); 

while ($row = $dbnivel->fetchassoc()){
$idagrupado=$row['id'];$nomagrup=$row['nombre'];$estado=$row['estado'];$html['filas' . $estado]++;$count=$html['filas' . $estado];

$html[$estado][].="<div class='agrup_V2' id='$count' onclick='selV2agrup(\"$idagrupado|$estado\")'>$nomagrup</div><input type='hidden' id='IDA-$idagrupado' value='$count'>";	

}



if (!$dbnivel->close()){die($dbnivel->error());};

	

return $html;	
		
	
}

?>