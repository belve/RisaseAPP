<?php

set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

require_once("../db.php");
$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};


$chki=0;
$queryp= "select id_articulo, stockmin from repartir where id_tienda=$idt limit 100;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$alar[$row['id_articulo']]=$row['stockmin'];};

if (!$dbnivel->close()){die($dbnivel->error());};

echo count($alar);




$conn=odbc_connect($t,'local','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM Articulos;";


$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}



$count=1;$values="";
while (odbc_fetch_row($rs))
 {
	$art_idArt=trim(utf8_encode(odbc_result($rs,'art_idArticulo')));
	$art_idArticulo=trim(utf8_encode(odbc_result($rs,'art_CodBarras')));
	$art_UniStock=trim(utf8_encode(odbc_result($rs,'art_UniStock')));
	$art_UniMini=trim(utf8_encode(odbc_result($rs,'art_UniMinimas')));
	
	if(array_key_exists($art_idArt, $alar)){$art_UniMini=$alar[$art_idArt];};
	
	$values .="('$art_idArt','$art_idArticulo','$art_UniStock','$art_UniMini'),";
  }

odbc_close($conn);

$values=substr($values, 0,strlen($values)-1);	


$dbnivelBAK=new DB('192.168.1.11','tpv','tpv','tpv_backup');
if (!$dbnivelBAK->open()){die($dbnivelBAK->error());};


$chki=0;
$queryp= "SHOW TABLES LIKE 'stocklocal_$idt';";
$dbnivelBAK->query($queryp);
while ($row = $dbnivelBAK->fetchassoc()){$chki=1;}

if(!$chki){
$queryp= "CREATE TABLE `stocklocal_$idt` (                        
              `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,  
              `id_art` bigint(100) DEFAULT NULL,                  
              `cod` bigint(50) DEFAULT NULL,                      
              `stock` int(22) DEFAULT NULL,                       
              `alarma` int(22) DEFAULT NULL,                      
              `pvp` decimal(8,2) DEFAULT NULL,                    
              PRIMARY KEY (`id`),                                 
              KEY `cod` (`cod`)                                      
               ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;";
			   
$dbnivelBAK->query($queryp);	
}



$queryp= "INSERT INTO stocklocal_$idt (id_art,cod,stock,alarma) VALUES $values;";
$dbnivelBAK->query($queryp);

$total=0;
$queryp= "select max(id) as total from stocklocal_$idt;";
$dbnivelBAK->query($queryp);
while ($row = $dbnivelBAK->fetchassoc()){$total=$row['total'];};


if (!$dbnivelBAK->close()){die($dbnivelBAK->error());};

$valores[1]="Importados $total";
echo json_encode($valores);

?>