<?php

require_once("../db.php");$htm="";
$dbnivelAPP=new DB('192.168.1.11','tpv','tpv','risase');
if (!$dbnivelAPP->open()){die($dbnivelAPP->error());};



$queryp= "select id_tienda, id from tiendas where activa=1;";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){
		
$id=$row['id'];
$id_tienda=$row['id_tienda'];		
		
$htm.="<div style='float:left; width:100px;'>$id_tienda: </div> <input onclick='javascript:doimp($id,\"$id_tienda\");' id='$id_tienda' type='submit' value='importar' style='float:left; margin-left:10px;'><div style='clear:both;'></div>  ";		
	
	
}






if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>imptstock</title>



</head>


<script>
function doimp(id,tie){$.ajaxSetup({'async': false});

var url='importadores/impstock2.php?t=' + tie + '&idt=' + id;

document.getElementById(tie).value="importando";
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

document.getElementById(tie).value=	val;	
	
});
});	
	
	
}	
	
	
</script>

<body class="gris1_BG">
	
<?php echo $htm;?>

</body>
</html>