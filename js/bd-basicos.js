function cargaColores(pointer){
url = "/ajax/basics-bd.php?tabla=colores&pointer=" + pointer;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
   document.getElementById('color_hid').value=key;
   document.getElementById('color_id').value=key;
   document.getElementById('color_name').value=val;
});
});
}

function cargaColoresMENOS(){
var actual=	document.getElementById('color_hid').value;
actual--;
cargaColores(actual);
}

function cargaColoresMAS(){
var actual=	document.getElementById('color_hid').value;
actual++;
cargaColores(actual);
}


function cargaColoresINI(){
cargaColores(0);
}

function cargaColoresFIN(){
cargaColores('-1');
}

function cargaColoresS(){
var actual=	document.getElementById('color_id').value;
cargaColores(actual);
}

function saveColor(){
var id=	document.getElementById('color_hid').value;	
var name=document.getElementById('color_name').value;	
url = "/ajax/update-bd.php?tabla=colores&id=" + id + "&name=" + name;
$.getJSON(url, function(data) {
});
}









function cargaGrupos(pointer){
url = "/ajax/basics-bd.php?tabla=grupos&pointer=" + pointer;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
   document.getElementById('grupos_hid').value=key;
   document.getElementById('grupos_id').value=key;
   document.getElementById('grupos_name').value=val;
});
});
}

function cargaGruposMENOS(){
var actual=	document.getElementById('grupos_hid').value;
actual--;
cargaGrupos(actual);
}

function cargaGruposMAS(){
var actual=	document.getElementById('grupos_hid').value;
actual++;
cargaGrupos(actual);
}


function cargaGruposINI(){
cargaGrupos(0);
}

function cargaGruposFIN(){
cargaGrupos('-1');
}

function cargaGruposS(){
var actual=	document.getElementById('grupos_id').value;
cargaGrupos(actual);
}

function saveGrupo(){
var id=	document.getElementById('grupos_hid').value;	
var name=document.getElementById('grupos_name').value;	
url = "/ajax/update-bd.php?tabla=grupos&id=" + id + "&name=" + name;
$.getJSON(url, function(data) {
});
}







