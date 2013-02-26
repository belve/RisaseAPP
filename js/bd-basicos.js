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