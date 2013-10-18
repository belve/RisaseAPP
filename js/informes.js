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
var detalles=document.getElementById(11).value
var comentarios=document.getElementById(12).value

var fini=document.getElementById('fini').value
var ffin=document.getElementById('ffin').value


//document.getElementById(2).value="";
//document.getElementById(3).value="";
//document.getElementById(4).value="";
//document.getElementById(5).value="";
//document.getElementById(6).value="";
//document.getElementById(7).value="";
//document.getElementById(8).value="";
//document.getElementById(9).value="";
//document.getElementById(10).value="";
	


if(codigo=='ventas'){
	var url="/informes/hventas.php?";
	var act=window.top.OrdV;
	var actO=window.top.OrdVO;
	
	};

if(codigo=='valorado'){
	var url="/informes/hvalorado.php?";
	var act=window.top.VOrdV;
	var actO=window.top.VOrdVO;
	
	};


	
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
 + "&comentarios=" + comentarios
 + "&detalles=" + detalles
 + "&fini=" + fini 
 + "&ffin=" + ffin 
 + "&act=" + act 
 + "&actO=" + actO 
 + '&listador=1'; 


fini=fini.replace('dd/mm/aaaa','');
ffin=ffin.replace('dd/mm/aaaa','');

if((fini=="")||(ffin=="")){
alert('Debe introducir un rango de fechas');	
}else{
getDATA(url);
}

}




function getDATA(url){$.ajaxSetup({'async': false});
document.getElementById('mphotos').setAttribute("style", "visibility:hidden;");
if(window.debug ==1) {console.log('url: ' + url);};
document.getElementById('status').innerHTML="CALCULANDO";
document.getElementById('reloj').setAttribute("style", "visibility:visible;");

	$.getJSON(url, function(data) {
	$.each(data, function(key, val) {
	if(key=='ng'){
	
	var timeOFF=val*6;
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
document.getElementById('mphotos').setAttribute("style", "visibility:visible;");

	
}


function popupPhotos(){

window.open('/informes/photos.php','1382091219155','width=300,height=700,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');


	
}



function orD(id){

document.getElementById('1|A').setAttribute("style", "visibility:hidden;");
document.getElementById('2|A').setAttribute("style", "visibility:hidden;");
document.getElementById('3|A').setAttribute("style", "visibility:hidden;");
document.getElementById('4|A').setAttribute("style", "visibility:hidden;");

document.getElementById('1|D').setAttribute("style", "visibility:hidden;");
document.getElementById('2|D').setAttribute("style", "visibility:hidden;");
document.getElementById('3|D').setAttribute("style", "visibility:hidden;");
document.getElementById('4|D').setAttribute("style", "visibility:hidden;");

var act=window.top.OrdV;
var actO=window.top.OrdVO;

if(id==act){if(actO=='A'){var nO='D';}else{var nO='A';}}else{var nO='D';};

window.top.OrdV=id;
window.top.OrdVO=nO;
document.getElementById(id + '|' + nO).setAttribute("style", "visibility:visible;");

	
	
}

function VorD(id){

document.getElementById('V|1|A').setAttribute("style", "visibility:hidden;");
document.getElementById('V|2|A').setAttribute("style", "visibility:hidden;");
document.getElementById('V|3|A').setAttribute("style", "visibility:hidden;");
document.getElementById('V|4|A').setAttribute("style", "visibility:hidden;");

document.getElementById('V|1|D').setAttribute("style", "visibility:hidden;");
document.getElementById('V|2|D').setAttribute("style", "visibility:hidden;");
document.getElementById('V|3|D').setAttribute("style", "visibility:hidden;");
document.getElementById('V|4|D').setAttribute("style", "visibility:hidden;");

var act=window.top.VOrdV;
var actO=window.top.VOrdVO;

if(id==act){if(actO=='A'){var nO='D';}else{var nO='A';}}else{var nO='D';};

window.top.VOrdV=id;
window.top.VOrdVO=nO;
document.getElementById('V|' + id + '|' + nO).setAttribute("style", "visibility:visible;");

	
	
}








