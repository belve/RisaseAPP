function paraguardar(tab,value){

var tab;
var value;	
var almacenado="";
	
if(getCookie(tab)){var almacenado=	getCookie(tab);};

if(almacenado.length == almacenado.replace(value,"").length){
var nuevo=almacenado + 'I' + value;
setCookie(tab,nuevo,1);
}
}

function modifield(tabla,campo,busco,id){
var valor=document.getElementById(busco).value;
url='/ajax/updatefield.php?tabla=' + tabla
+ '&campo=' + campo	
+ '&value=' + valor
+ '&id=' + id;

$.getJSON(url, function(data) {
});	
	
}


function save_tabla(tabla){

var iframe = document.getElementById(tabla);
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var url='/ajax/updatefields.php?tabla=' + tabla + "&";
if(getCookie(tabla)){

var almacenado=	getCookie(tabla);	
var datos =almacenado.split('I');
var campos="";

for (var i = 0; i < datos.length; i++) {
if(datos[i].length > 0){
	
var valor=innerDoc.getElementById(datos[i]).value;
campos= campos + 'campos[' + datos[i] + ']=' + valor + "&";	
	
}}}

url=url+campos;
setCookie(tabla,'',1);
$.getJSON(url, function(data) {
});	
}
	



function getCookie(c_name)
{
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
{
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}

function setCookie(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString()) + "; path=/";
document.cookie=c_name + "=" + c_value;
}

function guardacambios(tab){


var datos = nuevo.split('I');
var nuevo
for (var i = 0; i < datos.length; i++) {
   
}	
}



function changefield_art(value){
		
	var i=$("*:focus").attr("id");
	
	
	
	var datos = i.split('V');
	var fila = datos[1]; var columna= datos[0];
	
	
	if(value=='left'){
		columna--;
		var nuevo=columna + "V" + fila
	};
	
	if(value=='right'){
		columna++;
		var nuevo=columna + "V" + fila
	};
	
	
	if(value=='up'){
		fila--;
		var nuevo=columna + "V" + fila
	};
	
	if(value=='down'){
		fila++;
		var nuevo=columna + "V" + fila
		};	
	
	
	$('#'+ nuevo).focus().select();

	
}


function changefield_mas(value){
		
	var i=$("*:focus").attr("id");
	
	
	
	var datos = i.split('V');
	var fila = datos[0]; var columna= datos[1];
	
	
	if(value=='left'){
		columna--;
		var nuevo=fila + "V" + columna
	};
	
	if(value=='right'){
		columna++;
		var nuevo=fila + "V" + columna
	};
	
	
	if(value=='up'){
		fila--;
		var nuevo=fila + "V" + columna
	};
	
	if(value=='down'){
		fila++;
		var fil=document.getElementById('fil').value;
		
		if(fila > fil){create_grid();};
		
		var nuevo=fila + "V" + columna
		};	
	
	
	$('#'+ nuevo).focus().select();

	
}


function create_grid(){
var fil=document.getElementById('fil').value;
fil++;
document.getElementById('fil').value=fil;

var fila='<tr><td style="width:122px"><input type="text" class="camp_mas_rpro" 		value="" id="' + fil
 + 'V1"></td><td style="width:22px">	<input type="text" class="camp_mas_g" 		value="" id="' + fil
 + 'V2"></td><td style="width:22px">	<input type="text" class="camp_mas_s" 		value="" id="' + fil
 + 'V3"></td><td style="width:45px">	<input type="text" class="camp_mas_color"  	value="" id="' + fil
 + 'V4"></td><td style="width:45px">	<input type="text" class="camp_mas_cantidad"value="" id="' + fil
 + 'V5"></td><td style="width:45px">	<input type="text" class="camp_mas_alarma"	value="" id="' + fil
 + 'V6"></td><td style="width:45px">	<input type="text" class="camp_mas_precioC"	value="" id="' + fil
 + 'V7"></td><td style="width:45px">	<input type="text" class="camp_mas_pvp" 	value="" id="' + fil
 + 'V8"></td></tr>';

$('#grid').append(fila);
	
	
}


