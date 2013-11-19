

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>test</title>

<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />

<script>



	function brebajas(){
		
	url='/ajax/brebajas.php';
	$.getJSON(url, function(data) {
	$.each(data, function(key, val) {
		
	
	});
	});		
		
	document.getElementById('txt').innerHTML="Rebajas borradas.";		
	}
	
	
</script>


</head>
<body>	



<div id="txt">
Se borraran rebajas caducadas a dia de hoy.


<div style="margin-top:20px;" id="bt">
<div class="boton" style="width:150px;" id="bpro" onclick="brebajas();">Borrar</div>
</div>

</div>


</body>
</html>