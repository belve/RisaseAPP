<?php

require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id, id_grupo, clave, nombre from subgrupos order by id_grupo, clave;";	
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$valores[]=$row['id'] . "|" . $row['id_grupo'] . $row['clave'] ."|" . $row['nombre'];};



if (!$dbnivel->close()){die($dbnivel->error());};




echo json_encode($valores);




?>