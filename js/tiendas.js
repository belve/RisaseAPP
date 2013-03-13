function cargatiend(id){
url = "/ajax/loadtiend.php?id=" + id;

var antiguo=document.getElementById('seleccionado').value;
if(document.getElementById(antiguo)){document.getElementById(antiguo).setAttribute("class", "");};
document.getElementById('t-'+ id).setAttribute("class", "tselected");
document.getElementById('seleccionado').value='t-' + id;

$.getJSON(url, function(data) {
$.each(data, function(key, val) {
if(key==9){
	document.getElementById(9).checked=true;
}else{	
document.getElementById(key).value=val;
}
});
});
}

function ordenatienda(orden){
var cod=document.getElementById(1).value	
url = "/ajax/ordenatienda.php?cod=" + cod + "&orden=" + orden;  
$("#tiendas").load(url);



}

