<?php

$iva=21;


######## risasa
$delT=10;     #### elimina uno de cada
$tnoRISASA=array(27,39,13,7,6,5,2,331,16,21,4,28);	###### tiendas que no procesa
##################################


$equiEST['P']="ACTIVO";
$equiEST['F']="FINALIZADO";
$equiEST['A']="EN ALMACÉN";
$equiEST['T']="ENVIADO A TIENDAS";
$equiEST['E']="ENVIADO A TIENDAS";

$tab_sync['articulos']=1;
$tab_sync['empleados']=1;
$tab_sync['colores']=1;
$tab_sync['grupos']=1;
$tab_sync['subgrupos']=1;
$tab_sync['proveedores']=1;
$tab_sync['tiendas']=1;


global $dbnivel; global $tiendas;
$dbnivel=new DB('192.168.1.11','edu','admin','risase');

$pathimages="c:/D/fotos/";
$urlimages="/photos/";

require_once("../functions/gettiendas.php");
require_once("../functions/sync.php");
?>