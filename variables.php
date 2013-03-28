<?php

$iva=21;


$equiEST['F']="Finalizado";
$equiEST['A']="En Almacén";
$equiEST['T']="Enviado a Tiendas";

global $dbnivel; global $tiendas;
$dbnivel=new DB('192.168.1.11','edu','admin','risase');



require_once("../functions/gettiendas.php");

?>