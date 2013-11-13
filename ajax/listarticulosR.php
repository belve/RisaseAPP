<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="/js/tablas.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>



</head>

<script>

window.top.listAREPO=new Array();


$(document).keypress(function(e) {
      switch(e.keyCode) { 
      	
      	 // User pressed "left" arrow
         case 37:
           mrep('up'); break;
      	
       // User pressed "right" arrow
         case 39:
           mrep('down');break;
      	
         // User pressed "up" arrow
         case 38:
           mrep('up'); break;
         
         // User pressed "down" arrow
         case 40:
           mrep('down'); break;
         
         // User pressed "enter"
         case 13:
            mrep('down'); break;
      }
   });	
	
	
</script>



<body>

<style>

body {}
table 	{border-collapse:collapse; width:200px; background-color: white;}
tr		{height:20px;  }
td		{width: 90px; border: 1px  solid #888888; margin:0px;}
	
</style>




<?php
$id_proveedor="";$id_grupo="";$id_subgrupo="";$id_color="";$codigo="";$pvp="";$desde="";$hasta="";$temporada="";$hago="";$tempR="";

$detalles="";
$comentarios="";
$ord=1;
$tab=1;

if(count($_GET)>0){
	

	
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$options="";$forsync="";
require_once("../functions/listador.php");### recupera $options


$queryp= "select id, codbarras, stock, (select repo from reposiciones WHERE ida=articulos.id AND temp='$tempR') as repo, refprov, congelado, 
substring(codbarras,1,1) as g, substring(codbarras,2,1) as sg , substring(codbarras,5) as cod 
from articulos where $options ORDER BY g, sg, cod;"; 

$listado="";

$dbnivel->query($queryp);$count=1;$repo=0;
while ($row = $dbnivel->fetchassoc()){
$codbarras=$row['codbarras'];$refprov=$row['refprov'];	
$congelado=$row['congelado'];	if($congelado==1){$checked="checked";}else{$checked="";};
$ide=$row['id']; $repo=$row['repo']; $stock=$row['stock']; if(!$repo){$repo2=0;}else{$repo2=$repo;};

$listado .="
<tr>
<td style='width:140px'><input tabindex='z'  type='text' class='camp_artC_codbar' value='$codbarras'></td>
<td style='width:45px'><input tabindex='$ide' value='$repo' type='text' id='$ide' onfocus='sel(this.id)'; onchange='repon($ide,this.value,$repo2,$stock);'  style='border:0px; width:45px; font-size:9px; color:888888; text-align:right;' ></td>
<script> window.top.listAREPO.push($ide); </script>
</tr>
	";
$count++;
};

if (!$dbnivel->close()){die($dbnivel->error());};

if($forsync){SyncModBD($forsync);};



?>



<table>


<?php echo $listado;?>

</table>

<script>

function mrep(w){
var i=$("*:focus").attr("id");	
//console.log("i:" + i);
i=i*1;
var pos=window.top.listAREPO.indexOf(i);	

//console.log("pos:" + pos);

if(w=='up'){pos=pos-1;};
if(w=='down'){pos=pos+1;};

//console.log("pos:" + pos);

if(window.top.listAREPO[pos]){
	
var nid=window.top.listAREPO[pos];
//console.log("nid:" + nid);
setTimeout("$('#" + nid + "').focus();",10);
}	

}

function sel(id){
$('#'+ id).select();	
}



function repon(id,nrep,orep,stock){
var tmp='<?php echo $tempR;?>';

var nstock=Number((stock-orep)*1) + Number(nrep);

url = "/ajax/updateReposicion.php?id=" + id + "&nrep=" + nrep + "&nstock=" + nstock + "&tmp=" + tmp;
$.getJSON(url, function(data) {
});
	
}

//console.info(window.top.listAREPO);
   

parent.document.getElementById("timer").style.visibility = "hidden";
</script>
</body>
</html>

<?php
}
?>