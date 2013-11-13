<?php $ussid=$_SESSION['ussid']; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>Aplicación Gestión RISASE</title>


<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>




<link rel='stylesheet' type='text/css' href='/css/framework.css' />




</head>

<script>

$(window).keydown(function(evt) {
  if (evt.which == 17) { // ctrl
  document.getElementById('crtl').value=1;
  }
}).keyup(function(evt) {
  if (evt.which == 17) { // ctrl
  document.getElementById('crtl').value=0;
  }
});

</script>	




<body class="gris1_BG">
	
<input style="font-size:10px;" type="hidden" id="crtl" style="position:absolute;top:0px;left:0px; z-index: 999; " value="0">
	
<div class="page">


<div id="menu">
<ul id="nav">
	<li><a>Mantenimiento</a>
		<ul class="submenu">
        	<!-- <li onclick="javascript:owin('v_1','Test1');"><a>Test1</a></li> -->
        	<li onclick="javascript:owin('v_9','Articulos','');"><a>Articulos</a></li>
        	<li onclick="javascript:owin('v_7','Altas / Bajas','');"><a>Altas / Bajas</a></li>
        	<li onclick="javascript:owin('v_8','Altas masivas','');"><a>Altas masivas</a></li>
        	<li onclick="javascript:owin('v_47','Reposiciones','');"><a>Reposiciones</a></li>
        	<li onclick="javascript:owin('v_6','Tiendas','');"><a>Tiendas</a></li>
            <li onclick="javascript:owin('v_2','Colores','');"><a>Colores</a></li>
            <li onclick="javascript:owin('v_3','Grupos','');"><a>Grupos</a></li>
            <li onclick="javascript:owin('v_4','Subgrupos','');"><a>Subgrupos</a></li>
        	<li onclick="javascript:owin('v_5','Proveedores','');"><a>Proveedores</a></li>
        </ul>
	</li>
    
    <li><a>Gestión de Almacén</a>
    	<ul class="submenu">
        	<li onclick="javascript:owin('v_10','Artículos Congelados','');"><a>Artículos Congelados</a></li>
        	<li onclick="javascript:owin('v_23','Comentarios Masivos','');"><a>Comentarios Masivos</a></li>
        	<li onclick="javascript:owin('v_11','Repartir Artículos','');"><a>Repartir Artículos</a></li>
            <li onclick="javascript:owin('v_14','Repartos','');"><a>Repartos</a></li>
            <li onclick="javascript:owin('v_15','Pedidos','');"><a>Pedidos</a></li>
            <li onclick="javascript:owin('v_16','Pedidos en GRID','');"><a>Pedidos en GRID</a></li>
            <li onclick="javascript:owin('v_20','Rebajas','');"><a>Rebajas</a></li>
             <li onclick="javascript:owin('v_21','Fijar Stock en tienda','');"><a>Fijar Stock en tienda</a></li>
             <li onclick="javascript:owin('v_22','Fijar PVP en tienda','');"><a>Fijar PVP en tienda</a></li>
        </ul>
    	
    </li>
    
    <?php 
    if($ussid['ig']){
    ?>
    <li><a>Informes generales</a>
    	<ul class="submenu">
        	<li onclick="javascript:owin('v_30','Control de ventas','');"><a>Control de ventas</a></li>
        	<li onclick="javascript:owin('v_31','Por dias','');"><a>Por dias</a></li>
        	<li onclick="javascript:owin('v_32','Por empleado','');"><a>Por empleado</a></li>
        	<li onclick="javascript:owin('v_33','Por horas','');"><a>Por horas</a></li>
        	<li onclick="javascript:owin('v_34','Interanual','');"><a>Interanual</a></li>
        	<li onclick="javascript:owin('v_35','Mensual','');"><a>Mensual</a></li>
        	<li onclick="javascript:owin('v_36','Porcentaje de ventas','');"><a>Porcentaje de ventas</a></li>
        	<li onclick="javascript:owin('v_37','Ventas por tienda','');"><a>Ventas por tienda</a></li>
        	<li onclick="javascript:owin('v_38','Márgenes de beneficio','');"><a>Márgenes de beneficio</a></li>
        	<li onclick="javascript:owin('v_39','Ticket medio','');"><a>Ticket medio</a></li>
        	<li onclick="javascript:owin('v_25','Descuentos en tiendas','');"><a>Descuentos en tiendas</a></li>
        	<li onclick="javascript:owin('v_26','Facturación franquicias','');"><a>Facturación franquicias</a></li>
        	
        </ul>
    </li>
    <?php } ?>
    
 
    <li><a>Informes de almacén</a>
    	<ul class="submenu">
        	<li onclick="javascript:owin('v_40','Informe de Inventario','');"><a>Informe de Inventario</a></li>
        	<li onclick="javascript:owin('v_41','Informe de Devoluciones','');"><a>Informe de Devoluciones</a></li>
        	<li onclick="javascript:owin('v_42','Gastos en Mercancía','');"><a>Gastos en Mercancía</a></li>
        	<li onclick="javascript:owin('v_43','Descuadres de Stock','');"><a>Descuadres de Stock</a></li>
        </ul>
    </li>
 	
 
<?php if($ussid['ut']){   ?>
	   
    <li><a>Utilidades</a>
    	
    	<ul class="submenu">
        	<li onclick="javascript:owin('v_45','Procesar Risasa','');"><a>Procesar Risasa</a></li>
        	<li onclick="javascript:owin('v_46','Eliminador de referencias','');"><a>Eliminador de referencias</a></li>
        
        </ul>
    	
    </li>


<?php } ?>
</ul>
</div>




<div id="ventanas">


</div>


<div class="minimizadas" id="minimizadas">

</div>


</div>


</body>
</html>