<?php
require_once("../db.php");
require_once("../variables.php");

require_once("../functions/gettiendas.php");
$tip=2;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>test</title>


<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/pedidos.js"></script>



<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body>

<script>
$(window).keydown(function(evt) {
  if (evt.which == 17) { // ctrl
  top.document.getElementById('crtl').value=1;
  }
}).keyup(function(evt) {
  if (evt.which == 17) { // ctrl
  top.document.getElementById('crtl').value=0;
  }
});


</script>	


<!-- pestañas -->

<div class="lado"></div>
<div class="PestaniaON"  id="P1" onclick="selPEST('P1');">Agrupar</div>
<div class="PestaniaOFF" id="P2" onclick="selPEST('P2');">Gestionar</div>
<div class="NOpestania"></div>
<div style="clear:both;"></div>	

<div style="border-left:1px solid #888888; border-bottom: 1px solid #888888; border-right: 1px solid #888888; height:543px;margin-top:-1px; ">





<!-- agrupacion -->
<div class="VP1" id='VP1'>
<div style="float:left">
		
<div class="cabPEPEN" style="margin-top:10px;">
<div class="cabtab_PEPEN tab_PEPEN_art">Artículo</div>
<div class="cabtab_PEPEN tab_PEPEN_rep">REP</div>
</div>

<div style="clear:both;"></div>	
<iframe id="pedipent" src="/ajax/pedipent.php" width="303" height="400" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>

<div style="clear:both;"></div>	




	
<div class="boton" onclick="meteAgrup(<?php echo $tip;?>);">Añadir a agrupación >></div>

</div>



<div style="float:left; margin-left:20px;">	
	
<div class="cabPEPEN" style="margin-top:10px;width: 202px">
<div class="cabtab_PEPEN tab_PEPEN_agr">Agrupaciones</div>	
</div>

<div style="clear:both;"></div>	

<iframe id="agrupaciones" src="/ajax/agrupaciones.php" width="203" height="380" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>

<div class="cabPEPEN" style="height:20px;margin-top: -2px;width: 202px">
<input style="font-size:10px;" type="text" id="newgrup"><div class="iconos new_on" onclick="newAgrup(<?php echo $tip;?>);"></div>
</div>



<div style="clear:both;"></div>	



<div style="float:left: ">
<div class="boton" onclick="autoagrupar(<?php echo $tip;?>);">Auto-agrupar</div>	
</div>


</div>




<div style="float:left;margin-left:20px; ">
		
<div class="cabPEPEN" style="margin-top:10px;">
<div class="cabtab_PEPEN tab_PEPEN_art">Artículo</div>
<div class="cabtab_PEPEN tab_PEPEN_rep">REP</div>
</div>

<div style="clear:both;"></div>	
<iframe id="pediagrup" src="/ajax/pedipent.php" width="303" height="400" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>

<div style="clear:both;"></div>	




	
<div class="boton" onclick="sacaAgrup(<?php echo $tip;?>);"> << Sacar de agrupación </div>

</div>







<iframe id="print" src="" width="0" height="0" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe>
<div class="timer" id="timer1" style="visibility: hidden; left: 17%; top:17%;"><img src="/iconos/loading1.gif"></div>
<div class="timer" id="timer2" style="visibility: hidden; left: 46%; top:17%;"><img src="/iconos/loading1.gif"></div>
<div class="timer" id="timer3" style="visibility: hidden; left: 75%; top:17%;"><img src="/iconos/loading1.gif"></div>

<script>

	
</script>




</div><!-- agrupacion -->




<div style="clear:both;"></div>	




<!-- GESTIONAR -->
<div id="VP2" class="VP2">
<div style="float:left; ">	
	
<div style="width:150px;">
<div class="V2_lado"></div>	
<div class="V2_PEST_on"  id="V2P1" onclick="selPEST_V2('V2P1');">ACT</div>		
<div class="V2_PEST_off" id="V2P2" onclick="selPEST_V2('V2P2');">ALM</div>	
<div class="V2_PEST_off" id="V2P3" onclick="selPEST_V2('V2P3');">TIE</div>	
<div class="V2_PEST_off" id="V2P4" onclick="selPEST_V2('V2P4');">FIN</div>	
<div style="clear:both;"></div>	
<div class="subfranja"></div>
	
</div>

<div style="clear:both;"></div>	
<input type="hidden" id="V2SEL" value="V2P1">
<input type="hidden" id="ag_selected" value=""><input type="hidden" id="ag_selected_P" value="">
<input type="hidden" id="est_sel_act" value="">

<div class="agV2" style="" id="DV2P1">					<input type="hidden" id='nfV2P1' value=''>
<iframe id="FV2P1" src="/ajax/agrupacionesV2.php" width="111" height="380" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>

<div class="boton" style="margin-left:1px; width: 76px;" onclick="roturas(<?php echo $tip;?>);">Imp Roturas</div>
</div>

<div class="agV2" style="visibility: hidden" id="DV2P2"><input type="hidden" id='nfV2P2' value=''>
<iframe id="FV2P2" src="/ajax/agrupacionesV2.php" width="111" height="380" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
</div>


<div class="agV2" style="visibility: hidden" id="DV2P3"><input type="hidden" id='nfV2P3' value=''>
<iframe id="FV2P3" src="/ajax/agrupacionesV2.php" width="111" height="380" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
</div>


<div class="agV2" style="visibility: hidden" id="DV2P4"><input type="hidden" id='nfV2P4' value=''>
<iframe id="FV2P4" src="/ajax/agrupacionesV2.php" width="111" height="380" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
</div>



<div style="clear:both;"></div>	




</div>

<div class="bot_imp" id="bot_imp" style="visibility: hidden;">
	<div class="boton" style=" margin-left: 6px;    margin-top: 6px;    width: 76px;" onclick="impPED();">Imp Pedido</div>
</div>


<div style="clear:both;"></div>

<div style=" left: 130px;position: absolute;top: 0;">

<div class="contGridAgrup">


<div style="float: left" >
<div class="pg_titAG" id="nagru"></div>	
<input type="hidden" id="tip" value="<?php echo $tip;?>">

</div>
<div class="pg_hueco"></div>	
<div style="float:right;">
<div onclick="cambiaEst_agru('P',<?php echo $tip;?>);" class="pG_estado_off" id="P_E_P">Activo</div>
<div onclick="cambiaEst_agru('A',<?php echo $tip;?>);" class="pG_estado_off" id="P_E_A">En almacén</div>
<div onclick="cambiaEst_agru('T',<?php echo $tip;?>);" class="pG_estado_off" id="P_E_T">Enviado a tienda</div>
<div onclick="cambiaEst_agru('F',<?php echo $tip;?>);" class="pG_estado_off" id="P_E_F">Finalizado</div>
</div>



<div style="clear:both;"></div>
<div style="height:8px;background-color:orange;border-right: 1px solid #888888;border-left: 1px solid #888888;margin-top:-1px"></div>
	
<div class="cabREP" style="width: 845px;margin-top:0px ">
	<div class="cabtab_REP tab_REP_art">Artículos</div>
	<div class="cabtab_REP tab_REP_rep">REP</div>
	<div class="cabtab_REP tab_REP_alm">ALM</div>

<div id="optCABE">
<?php
$postiendas=0;
foreach($tiendas as $idt => $nomt){
$postiendas++;
echo "<div onclick='sumatienda($postiendas,\"$nomt\")' class='cabtab_REP tab_REP_tie'>$nomt</div>";	
}

?>
</div>
	
</div>
<iframe id="GRID" src="/ajax/grid.php" width="847" height="400" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>

</div>

</div>


<div class="timer" id="timer4" style="visibility: hidden; left: 520px; top:119px;"><img src="/iconos/loading1.gif"></div>
<div class="timer" id="timer" style="visibility: hidden; left: 520px; top: 200px;"><img src="/iconos/loading1.gif"></div>












<script>
setTimeout('cargaAgrupados(<?php echo $tip;?>,0);', 1000); 
setTimeout('cargaAgrupados2(<?php echo $tip;?>,0);', 1000); 
setTimeout('cargaPendientes(<?php echo $tip;?>);', 1000); 




</script>
	
</div><!-- GESTIONAR -->







</div>




</body></html>