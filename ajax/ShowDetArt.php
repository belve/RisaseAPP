<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");



if (!$dbnivel->open()){die($dbnivel->error());};
if($orig==1){
$queryp= "select 
(select nombre from proveedores where id=id_proveedor) as prov, 
(select nombre from grupos where id IN (select id_grupo from subgrupos where id=id_subgrupo)) as grup, 
(select nombre from subgrupos where id=id_subgrupo) as subg, 
(select nombre from colores where id=id_color) as color, 
refprov, stock, uniminimas, stockini 
from articulos where id=$idarticulo;";
}

$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$prov=$row['prov'];	$grup=$row['grup']; $subg=$row['subg']; $color=trim($row['color']); $refprov=$row['refprov']; $stock=$row['stock']; 
	
};

$datos="
$prov \n\n
$grup/ $subg/ $color/ $refprov \n
\n
Stock: $stock
";



if (!$dbnivel->close()){die($dbnivel->error());};

$valores['datos']=$datos;
echo json_encode($valores);

?>

