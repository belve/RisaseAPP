<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>Aplicación Gestión RISASE</title>


<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>


<script>




function loggin(){


var user=document.getElementById('user').value;	
var pass=document.getElementById('pass').value;	

url = "/ajax/loggin.php?user=" + user + '&pass=' + pass;

$.getJSON(url, function(data) {
$.each(data, function(key, val) {
if(key=='ok'){
 window.location.href = "/";
}else{
document.getElementById('user').value="";
document.getElementById('pass').value="";	
}

});
});	
		
		
	}
	
</script>

<link rel='stylesheet' type='text/css' href='/css/framework.css' />
<body class="gris1_BG">



<div class="loggin" id="loggin">
	<div class="contenedor gris2_BG shadow">
		<div class="cabcontenerdor">
			<div class="tit_contenedor">Loggin</div>
			<div onclick="javascript:cwin('loggin')" class="iconos closeW"></div></div>
			<div class="iframe">
		
			<div style="margin-top:5px; margin-left: 30px;">
			<div style="color:#444444; font-size:10px; margin-left: 2px;">Usuario:</div>
			<div><input type='text' id='user' style='width:150px; color:#444444; font-size:10px;' /></div>	
			
			<div style="color:#444444; font-size:10px; margin-left: 2px; margin-top: 4px">Contraseña:</div>
			<div><input type='password' id='pass' style='width:150px; color:#444444; font-size:10px;'  /></div>	
			
			<input type="button" onclick="login();"  value="Loggin" style="color:#444444; font-size:10px; width:80px; height: 20px; margin-top:10px; margin-left:39px;";>
			</div>	
			
			</iframe>
			</div></div>
			</div>


<script>
document.getElementById('user').focus();		
</script>	
</body>
</html>
