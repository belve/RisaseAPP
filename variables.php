<?php

$iva=21;


$equiEST['P']="ACTIVO";
$equiEST['F']="FINALIZADO";
$equiEST['A']="EN ALMACÉN";
$equiEST['T']="ENVIADO A TIENDAS";

$tab_sync['articulos']=1;

global $dbnivel; global $tiendas;
$dbnivel=new DB('192.168.1.11','edu','admin','risase');



require_once("../functions/gettiendas.php");
require_once("../functions/sync.php");

?>