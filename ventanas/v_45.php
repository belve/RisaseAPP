<?php
require_once("../db.php");
require_once("../variables.php");


$dbnivel2=new DB('192.168.1.11','edu','admin','risasa');
if (!$dbnivel2->open()){die($dbnivel2->error());};
$queryp= "select id_ticket from tickets ORDER BY id DESC limit 1;"; 
$dbnivel2->query($queryp);
while ($row = $dbnivel2->fetchassoc()){$mid=$row['id_ticket'];};
if (!$dbnivel2->close()){die($dbnivel2->error());};



if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id from tickets where id_ticket='$mid';"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$lid=$row['id'];};
	
$queryp= "select count(id) as tot from tickets where id > $lid;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$tot=$row['tot'];};

$queryp= "select max(id) as midt from tickets;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$midt=$row['midt'];};	
	
if (!$dbnivel->close()){die($dbnivel->error());};
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>test</title>

<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />

<script>

    function doit0(id,idf,tot){
    document.getElementById('bt').innerHTML="0% Procesado.";	
    doit1(id,idf,tot);
    }

	function doit1(id,idf,tot){
		
	url='/ajax/pRISASA.php?iid=' + id + '&fid=' +idf;
	$.getJSON(url, function(data) {
	$.each(data, function(key, val) {
		
		if((key==1)&&(val>0)){
		var func="doit2(" + val + "," + idf + "," + tot + ")";
				
		var por=100 - ((idf - val)*100)/tot; por=Math.round(por);
		document.getElementById('bt').innerHTML= por + "% Procesado";

		setTimeout(func, 1000);		
		}else{
		fin();	
		}
	
	
	});
	});		
		
		
	}
	
	function doit2(id,idf,tot){
	 	
	url='/ajax/pRISASA.php?iid=' + id + '&fid=' +idf;
	$.getJSON(url, function(data) {
	$.each(data, function(key, val) {
		
		if((key==1)&&(val>0)){
		var func="doit2(" + val + "," + idf + "," + tot + ")";
		
		var por=100 - ((idf - val)*100)/tot; por=Math.round(por);
		document.getElementById('bt').innerHTML= por + "% Procesado";
		
		setTimeout(func, 1000);		
		}else{
		fin();	
		}
	
	
	});
	});		
		
		
	}

function fin(){
document.getElementById('bt').innerHTML="100% Procesado.";	

document.getElementById('txt').innerHTML="No hay tickets pendientes de procesar.";	

}	
	
</script>


</head>
<body>	

<?php if($lid < $midt){ ?>
<div id="txt">
Se procesarán del ticket <?php echo $lid; ?> al <?php echo $midt; ?>.
<br>
Se morderá uno de cada <?php echo $delT; ?> tickets.
</div>

<div style="margin-top:20px;" id="bt">
<div class="boton" style="width:150px;" id="bpro" onclick="doit0(<?php echo $lid;?>,<?php echo $midt;?>,<?php echo $tot;?>);">Procesar</div>
</div>
<?php }else{  ?>

No hay tickets pendientes de procesar.

<?php }  ?>
</body>
</html>