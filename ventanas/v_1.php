<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="/js/focus.js"></script>





</head>





<body>
	
<div id="list_tiendas" class="blnco_limpio" style="float:left;">

<ul>
	<li>01 - MER</li>
	<li>02 - VAG</li>
	<li>03 - ALCB</li>
	<li>04 - ALU</li>
	<li>05 - MON</li>
	<li>06 - HER</li>
</ul>	
	
</div>

<div style="margin-left:20px; float:left; ">
<div style="width:580px; height: 160px; margin-bottom:20px;">




<div style="float: left; width:290px;">	
	<table>
		<tr>
			<td>Código</td>
			<td><input class="corto" text" name="COD" /></td>
		</tr>
		
		<tr>
			<td>C.Postal</td>
			<td><input class="corto" type="text" name="CP" /></td>
		</tr>
		
		<tr>
			<td>Población</td>
			<td><input class="largo" type="text" name="COD" /></td>
		</tr>
		
		<tr>
			<td>Comunidad</td>
			<td><input class="largo" type="text" name="COD" /></td>
		</tr>
		
		<tr>
			<td>Telefono</td>
			<td><input class="medio" type="text" name="COD" /></td>
		</tr>
	</table>
</div>	




<div style="float: left; width:280px;">	
	<table>
		<tr>
			<td>Nombre</td>
			<td><input class="largo" type="text" name="COD" /></td>
		</tr>
		
		<tr>
			<td>Direccion</td>
			<td><input class="largo" type="text" name="CP" /></td>
		</tr>
		
		<tr>
			<td>Provincia</td>
			<td><input class="largo"  type="text" name="COD" /></td>
		</tr>
		
		

	</table>
</div>	


	
</div>




	
	
<script type="text/javascript">
    $(document).ready(function(){

        $('#scrollbar1').tinyscrollbar();

    });
    
    

   // Register keypress events on the whole document
   $(document).keypress(function(e) {
      switch(e.keyCode) { 
         // User pressed "up" arrow
         case 38:
           changefield('up');
         break;
         // User pressed "down" arrow
         case 40:
           changefield('down');
         break;
         // User pressed "enter"
         case 13:
            changefield('down');
         break;
      }
   });
   
$("input[type=text]").focus().select();

</script>




<style>
	
#scrollbar1 { width: 517px; clear: both; margin: 0px 0 10px; }
#scrollbar1 .viewport { width: 507px; height: 240px; overflow: hidden; position: relative; }

#scrollbar1 .overview { list-style: none; position: absolute; left: 0; top: 0; background-color: white;}
#scrollbar1 .thumb .end,
#scrollbar1 .thumb { background-color: #B8B8B8; height:40px;}
#scrollbar1 .scrollbar { position: relative; float: right; width: 15px; }
#scrollbar1 .track { background-color: #d8d8d8; height: 100%; width:13px; position: relative; padding: 0 1px; }
#scrollbar1 .thumb { height: 20px; width: 13px; cursor: pointer; overflow: hidden; position: absolute; top: 0; }
#scrollbar1 .thumb .end { overflow: hidden; height: 5px; width: 13px; }
#scrollbar1 .disable{ display: none; }
.noSelect { user-select: none; -o-user-select: none; -moz-user-select: none; -khtml-user-select: none; -webkit-user-select: none; }






.titulOLISTA {clear:both; background-color:#B8B8B8; text-align: center; border-bottom:1px solid #444444; border-top:1px solid #444444;  height: 22px; margin-top:3px;}
.filacamp {clear:both; background-color:#ffffff; text-align: center; border-bottom:1px solid #444444;  height: 22px; }

.fila0 {border-left:1px solid #444444;padding:0px;margin:0px; float:left;  height: 22px; width:100px;}
.fila1 {border-left:1px solid #444444;padding:0px;margin:0px; float:left;  height: 22px; width:200px;}

.campotab {width:95%;border:0px; font-family: Arial; font-size:12px; height:18px; margin-top:2px;}

</style>


<div style=" width:516px; height: 240px; border-right:1px solid #444444; border-bottom:1px solid #444444;">


		
<div class="titulOLISTA">
	<div class="fila0">aaaaa</div><div class="fila1">bbbbbb</div><div class="fila1">cccccc</div>
</div>
		

	
	<div id="scrollbar1">
    <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
    <div class="viewport">
        <div class="overview">
            

		<div class="filacamp">
		<div class="fila0"><input class="campotab" type="text" value="eee" name="" id="1" onfocus="this.select()"  onchange="javascript:modifield(1);" ></div>
		<div class="fila1"><input class="campotab" type="text" value="ddddd" name="" id="amv"></div>
		<div class="fila1"><input class="campotab" type="text" value="dttttt" name=""></div>
		</div>
	
		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name="" id="2" onfocus="this.select()" onchange="javascript:modifield(2);" ></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name="" id="3" onfocus="this.select()"  onchange="javascript:modifield(3);" ></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name="" id="4" onfocus="this.select()"  onchange="javascript:modifield(4);" ></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name="" id="5" onfocus="this.select()"  onchange="javascript:modifield(5);" ></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name="" id="6" onfocus="this.select()"  onchange="javascript:modifield(6);" ></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>


		<div class="filacamp">	<div class="fila0"><input class="campotab" type="text" value="ttrtrr" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div><div class="fila1"><input class="campotab" type="text" value="" name=""></div>
		</div>




 </div>
    </div>
</div>
	
	
	
</div>



</div>


</body>
</html>