<?php

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};



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

	$art_idArticulo=trim(utf8_encode(odbc_result($rs,'art_CodBarras')));
	$art_UniStock=trim(utf8_encode(odbc_result($rs,'art_UniStock')));
	$art_UniMini=trim(utf8_encode(odbc_result($rs,'art_UniMinimas')));
	
	$values .="('$art_idArticulo','$art_UniStock','$art_UniMini'),";
  }

odbc_close($conn);

$values=substr($values, 0,strlen($values)-1);	

require_once("../db.php");
$dbnivelBAK=new DB('192.168.1.11','tpv','tpv','tpv_backup');
if (!$dbnivelBAK->open()){die($dbnivelBAK->error());};


$chki=0;
$queryp= "SHOW TABLES LIKE 'stocklocal_$idt';";
$dbnivelBAK->query($queryp);
while ($row = $dbnivelBAK->fetchassoc()){$chki=1;}

if(!$chki){
$queryp= "CREATE TABLE `stocklocal_$idt` (                        
                 `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,  
                 `cod` bigint(50) DEFAULT NULL,                      
                 `stock` int(22) DEFAULT NULL,                       
                 `alarma` int(22) DEFAULT NULL,                      
                 `pvp` decimal(8,2) DEFAULT NULL,                    
                 PRIMARY KEY (`id`),                                 
                 KEY `cod` (`cod`)                                   
               ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;";
			   
$dbnivelBAK->query($queryp);	
}

echo $chki;

$queryp= "INSERT INTO stocklocal_$idt (cod,stock,alarma) VALUES $values;";
$dbnivelBAK->query($queryp);


if (!$dbnivelBAK->close()){die($dbnivelBAK->error());};


?>