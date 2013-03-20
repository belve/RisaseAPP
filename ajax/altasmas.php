
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="/js/tablas.js"></script>




</head>





<body>

<style>

body {}
table 	{border-collapse:collapse; width:419px; background-color: white;}
tr		{height:20px;  }
td		{width: 90px; border: 1px  solid #888888; margin:0px;}
	
</style>

<input type="hidden" id="fil" value="1">

<table id='grid'>

<tr>
<td style='width:122px'><input type='text' class='camp_mas_rpro' 	value='' id='1V1'></td>
<td style='width:22px'>	<input type='text' class='camp_mas_g' 		value='' id='1V2'></td>
<td style='width:22px'>	<input type='text' class='camp_mas_s' 		value='' id='1V3'></td>
<td style='width:45px'>	<input type='text' class='camp_mas_color'  	value='' id='1V4'></td>
<td style='width:45px'>	<input type='text' class='camp_mas_cantidad'value='' id='1V5'></td>
<td style='width:45px'>	<input type='text' class='camp_mas_alarma'	value='' id='1V6'></td>
<td style='width:45px'>	<input type='text' class='camp_mas_precioC'	value='' id='1V7'></td>
<td style='width:45px'>	<input type='text' class='camp_mas_pvp' 	value='' id='1V8'></td>
</tr>

</table>


<script>


$(document).keypress(function(e) {
      switch(e.keyCode) { 
      	
      	 // User pressed "left" arrow
         case 37:
           changefield_mas('left'); break;
      	
       // User pressed "right" arrow
         case 39:
           changefield_mas('right');break;
      	
         // User pressed "up" arrow
         case 38:
           changefield_mas('up'); break;
         
         // User pressed "down" arrow
         case 40:
           changefield_mas('down'); break;
         
         // User pressed "enter"
         case 13:
            changefield_mas('down'); break;
      }
   });

   


</script>
</body>
</html>
