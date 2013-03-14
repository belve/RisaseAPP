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
