<?php
ini_set("memory_limit", "-1");
session_start();
$grid=$_SESSION['grid'];
$anchos=$_SESSION['anchos'];
$align=$_SESSION['align'];
$crang=$_SESSION['crang'];
$Mrang=$_SESSION['Mrang'];
$BTrang=$_SESSION['BTrang'];
$nomfil=$_SESSION['nomfil'];
$format=$_SESSION['format'];
$paginas=$_SESSION['paginas'];
$cdg=$_SESSION['cgd']; 


$pathimages="c:/D/fotos/";
$urlimages="http://192.168.1.11/photos/";

if(count($cdg)>0){foreach ($cdg as $codbarras => $pp){

$file = fopen ("http://192.168.1.11/ajax/getimage.php?codbarras=$codbarras", "r");
while (!feof ($file)) { $fotos = fgets ($file, 1024);};
fclose($file);

$dfotos=json_decode($fotos, true);
$afotos=$dfotos['img'];
$acodes=$dfotos['cod'];

if(array_key_exists(0, $afotos)){
$valores[$codbarras]=str_replace($pathimages, $urlimages, $afotos[0]);
}else{
$valores[$codbarras]= $urlimages . "nodisp.jpg";	
}



}}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>test</title>


<script>



</script>

<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>

<script type="text/javascript" src="/js/bd-basicos.js"></script>
<script type="text/javascript" src="/js/informes.js"></script>
<script src="/js/ffecha.js" type="text/javascript"></script>


<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body>
<div style="margin-left: 15px;">	
<?php

foreach ($valores as $cod => $url) {

echo "<div style='margin-top:10px; font-size:15px; font-weight:bold; text-align:center; width:130px;'> $cod </div>";
echo "<div> <img src='$url' style='height:100px;'> </div>";  		
	
}


?>
</div>

</body>
</html>