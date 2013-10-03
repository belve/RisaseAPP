window.debug =1;


function informe(codigo){


var prov=document.getElementById(2).value
var grup=document.getElementById(3).value
var subg=document.getElementById(4).value
var colo=document.getElementById(5).value
var codi=document.getElementById(6).value
var pvp=document.getElementById(7).value
var desd=document.getElementById(8).value
var hast=document.getElementById(9).value
var temp=document.getElementById(10).value

var fini=document.getElementById('fini').value
var ffin=document.getElementById('ffin').value


document.getElementById(2).value="";
document.getElementById(3).value="";
document.getElementById(4).value="";
document.getElementById(5).value="";
document.getElementById(6).value="";
document.getElementById(7).value="";
document.getElementById(8).value="";
document.getElementById(9).value="";
document.getElementById(10).value="";
	


if(codigo=='ventas'){var url="/informes/hventas.php?";};
	
url = url 
 + "id_proveedor=" + prov
 + "&id_grupo=" + grup
 + "&id_subgrupo=" + subg
 + "&id_color=" + colo
 + "&codigo=" + codi
 + "&pvp=" + pvp
 + "&desde=" + desd
 + "&hasta=" + hast
 + "&temporada=" + temp 
 + "&fini=" + fini 
 + "&ffin=" + ffin 
 + '&listador=1'; 






getDATA(url);

}




function getDATA(url){$.ajaxSetup({'async': false});

if(window.debug ==1) {console.log('url: ' + url);};
document.getElementById('status').innerHTML="CALCULANDO";
document.getElementById('reloj').setAttribute("style", "visibility:visible;");

	$.getJSON(url, function(data) {
	$.each(data, function(key, val) {
	if(key=='ng'){
	
	var timeOFF=val*4;
	loadExcel(timeOFF);
	}
	
	});
	});	

	
	
}

function loadExcel(timeOFF){$.ajaxSetup({'async': false});
document.getElementById('status').innerHTML="RENDERIZANDO";
document.getElementById('excel').src='/informes/excel.php';
setTimeout('finCALC()', timeOFF);	
}


function finCALC(){$.ajaxSetup({'async': false});

document.getElementById('status').innerHTML="";
document.getElementById('reloj').setAttribute("style", "visibility:hidden;");	
}

