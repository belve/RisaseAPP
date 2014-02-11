function updtTXTcat(id,idc){
var cont=document.getElementById(id).value;
var url='/ajx/updateTXTcat.php?campo=' + id + '&cont=' + cont + '&idc=' + idc;

$.getJSON(url, function(data) {
$.each(data, function(key, val) {

if(key=='text_desc'){
if(document.getElementById('txtDesc')){document.getElementById('txtDesc').innerHTML=val;};	
}	
	
});
});

}

function delKWD(id){
$( "#"+id ).remove();	
var url='/ajx/updateKEYWORDS.php?del=' + id;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
});
});	
}

function updtKWDS(ob,idc){
var keyw=document.getElementById(ob).value;	
var url='/ajx/updateKEYWORDS.php?keyw=' + keyw + '&idc=' + idc;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
if(key=='html'){
document.getElementById('lkwd').innerHTML=val;	
}

});
});	
document.getElementById(ob).value="";	
}
