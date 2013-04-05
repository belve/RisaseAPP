<?php





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
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
$ref=$row['codbarras'] . " / " . $row['refprov'];
$rep=$row['rep'];
$idart=$row['id_articulo'];

$html.= "
<div class='pedPen' id'$idart'>
<div class='pedPen_ART'>$ref</div>
<div class='pedPen_REP'>$rep</div>
</div>
";	

	
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
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
$ref=$row['codbarras'] . " / " . $row['refprov'];
$rep=$row['rep'];
$idart=$row['id_articulo'];

$html.= "
<div class='pedPen' id'$idart'>
<div class='pedPen_ART'>$ref</div>
<div class='pedPen_REP'>$rep</div>
</div>
";	

	
};



if (!$dbnivel->close()){die($dbnivel->error());};

return $html;	
}



?>