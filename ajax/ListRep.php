<?php

require_once("../db.php");
require_once("../variables.php");


$html="";

if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select * from repartos limit 50;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	
	$idREP=$row['id'];$nomrep=$row['nomrep'];$fecha=$row['fecha'];$estado=$equiEST[$row['estado']];

$html.= "
<div class='cabLREP_fil0' ondblclick='opRep($idREP)'>
	<div class='cabtab_LREP0 tab_LREP_1'>$nomrep</div>
	<div class='cabtab_LREP0 tab_LREP_2'>$fecha</div>
	<div class='cabtab_LREP0 tab_LREP_3'>$estado</div>
</div>
<div class='clear:both;'></div>
";	

};

if (!$dbnivel->close()){die($dbnivel->error());};



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/js/tablas.js"></script>
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />




</head>





<body>

<style>

body {}
table 	{border-collapse:collapse;  background-color: white;}
tr		{height:20px;  }
td		{width: 90px; border: 1px  solid #888888; margin:0px;}
	
</style>







<?php echo $html; ?>





<script>
	parent.document.getElementById("timer").style.visibility = "hidden";
</script>

</body>
</html>
