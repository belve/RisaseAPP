<?php


require_once("../db.php");
require_once("../variables.php");

$numtiendas=count($tiendas);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/js/tablas.js"></script>
<script type="text/javascript" src="/js/pedidos.js"></script>
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


<div id="repnue">

</div>


<input type="hidden" id="filsel" value="">
<input type="hidden" id="idrep" value="">
<input type="hidden" id="filas" value="">
<input type="hidden" id="columnas" value="<?php echo $numtiendas; ?>">


<input type="hidden" id="LinCOP" value="" >

<table id='grid'>
</table>

<table id='grid2'>
</table>



<script>




$(document).keypress(function(e) {
      switch(e.keyCode) { 
      	
      	 // User pressed "left" arrow
         case 37:
           moveFieldGRID('left'); break;
      	
       // User pressed "right" arrow
         case 39:
           moveFieldGRID('right');break;
      	
         // User pressed "up" arrow
         case 38:
           moveFieldGRID('up'); break;
         
         // User pressed "down" arrow
         case 40:
           moveFieldGRID('down'); break;
         
         // User pressed "enter"
         case 13:
            moveFieldGRID('down'); break;
      }
   });
 


</script>

</body>
</html>
