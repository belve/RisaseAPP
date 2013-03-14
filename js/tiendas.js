function cargatiend(id){
url = "/ajax/loadtiend.php?id=" + id;

var antiguo=document.getElementById('seleccionado').value;
if(document.getElementById(antiguo)){document.getElementById(antiguo).setAttribute("class", "");};
document.getElementById('t-'+ id).setAttribute("class", "tselected");
document.getElementById('seleccionado').value='t-' + id;
document.getElementById('seleccionado2').value=id;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
if(key==9){
	document.getElementById(9).checked=true;
}else{	
document.getElementById(key).value=val;
}
});
});

document.getElementById('empleados').src='/ajax/listempleados.php?id=' + id;
setCookie('empleados','',1);

}

function ordenatienda(orden){
var cod=document.getElementById(1).value	
url = "/ajax/ordenatienda.php?cod=" + cod + "&orden=" + orden;  
$("#tiendas").load(url);



}


function savetienda(){
var id=	document.getElementById('seleccionado2').value;
var id_tienda=	document.getElementById('1').value;	
var nombre=document.getElementById('2').value;
var cp=document.getElementById('3').value;
var direccion=document.getElementById('4').value;
var poblacion=document.getElementById('5').value;
var ciudad=document.getElementById('6').value;
var provincia=document.getElementById('7').value;
var telefono=document.getElementById('8').value;
	
url = "/ajax/update2.php?tabla=tiendas"
+ "&campos[nombre]=" + nombre  
+ "&campos[cp]=" + cp  
+ "&campos[direccion]=" + direccion  
+ "&campos[poblacion]=" + poblacion  
+ "&campos[ciudad]=" + ciudad  
+ "&campos[provincia]=" + provincia  
+ "&campos[telefono]=" + telefono  


+  "&id=" + id;
$.getJSON(url, function(data) {
});	
	
}

function createtienda(){
var newcod=document.getElementById('newcod').value;
if(newcod==""){
	alert('Introduzca un codigo de tienda');
}else{
url = "/ajax/createtienda.php?newcod=" + newcod;  
$("#tiendas").load(url);	
}
}


function create_empleados(){
var idtienda=document.getElementById('seleccionado2').value;	
var url='/ajax/create_empleado.php?idt=' + idtienda;

document.getElementById('empleados').src=url;	
}


