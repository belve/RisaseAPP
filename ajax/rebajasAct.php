<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="/js/tablas.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>
<script type="text/javascript" src="/js/rebajas.js"></script>


</head>



<style>
	.tLineR { background-color: #FFFFFF;
    border-bottom: 1px solid #888888;
    border-left: 1px solid #888888;
    border-right: 1px solid #888888;
    font-size: 10px;
    height: 28px;
    padding: 2px;
    position: relative;
    width: 181px;}

	.tLineR_N {float:left;position:relative; width: 110px;}
	.tLineR_p {float:right;position:relative; width: 56px;}
</style>

<body>

<?php
$action="";

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$fecha = date('Y') . "-" . date('m') . "-" . date('d');

$cajt="";
foreach ($tiendas as $idt => $nomt) {
$cajt.="$idt ";	
}
$cajt=trim($cajt);


$tabla="";$todos="";$ocult="";

if($action=='c'){
	
$fini=substr($fini,6,4) . "/" . substr($fini,3,2) . "/" . substr($fini,0,2);
$ffin=substr($ffin,6,4) . "/" . substr($ffin,3,2) . "/" . substr($ffin,0,2);	
	
$queryp= "insert into rebajas (nombre,fini,ffin) values ('$nombre','$fini','$ffin');";
$dbnivel->query($queryp);	
	
}


$last="";;
$queryp= "SELECT LAST_INSERT_ID() as lid from rebajas;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$last=$row['lid'];};



$queryp= "select id from rebajas where ffin >= '$fecha';";

$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$id=$row['id'];

$todos .="$id,";	
}
$todos=substr($todos, 0,strlen($todos)-1);


$queryp= "select * from rebajas where ffin >= '$fecha' order by id DESC;";

$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$nombre=$row['nombre']; 
$i=$row['fini'];
$f=$row['ffin'];

$fini=substr($row['fini'],8,2) . "/" . substr($row['fini'],5,2) . "/" . substr($row['fini'],0,4);
$ffin=substr($row['ffin'],8,2) . "/" . substr($row['ffin'],5,2) . "/" . substr($row['ffin'],0,4);
$id=$row['id'];$tiendon=$row['tiendas'];

	
$tabla .="<div class='tLineR' onclick='javascript:selReb($id,\"$todos\");' id='$id'>
<div class='tLineR_N'>$nombre</div> <div class='tLineR_p'>$fini $ffin</div>
</div>
<input type='hidden' id='t_$id' value='$tiendon'>
<input type='hidden' id='i_$id' value='$i'>
<input type='hidden' id='f_$id' value='$f'>

";	



} 

echo $tabla;
if (!$dbnivel->close()){die($dbnivel->error());};

if ($last){echo "<script>selReb($last,\"$todos\");</script>";}

?>


<input type="hidden" id="tdt" value="<?php echo $cajt;?>">

</body>