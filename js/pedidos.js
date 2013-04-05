
function timerAD(w,cual,donde){

if(donde==0){
if(w==0){document.getElementById(cual).style.visibility = "hidden";document.body.style.cursor = 'default';};
if(w==1){document.getElementById(cual).style.visibility = "visible";document.body.style.cursor = 'wait';};	
}

if(donde==1){
if(w==0){parent.document.getElementById(cual).style.visibility = "hidden";document.body.style.cursor = 'default';};
if(w==1){parent.document.getElementById(cual).style.visibility = "visible";document.body.style.cursor = 'wait';};	
}
	
}


function selectAgrup(id,tip){
var lastsel=document.getElementById('agrupSel').value;
if(lastsel!=id){
if(lastsel!=''){document.getElementById(lastsel).setAttribute("style", "background-color:white;");};	
document.getElementById(id).setAttribute("style", "background-color:#8DC29E;");		
document.getElementById('agrupSel').value=id;
detAgrupado(id,tip);
}}


function cargaPendientes(tip){$.ajaxSetup({'async': false});	
timerAD(1,'timer1',0);

var url='/ajax/actionPedidos.php?tip=' + tip + '&action=1';
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var iframe = document.getElementById('pedipent');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
if(key=='html'){innerDoc.getElementById('pedipent').innerHTML=val;};		
	
});
});	

timerAD(0,'timer1',0);
}


function cargaAgrupados(tip,agrupar){$.ajaxSetup({'async': false});	
timerAD(1,'timer2',0);

var url='/ajax/actionPedidos.php?tip=' + tip + '&action=2&agrupar=' + agrupar;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var iframe = document.getElementById('agrupaciones');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
if(key=='html'){innerDoc.getElementById('agrupaciones').innerHTML=val;};		
	
});
});	

timerAD(0,'timer2',0);
	
}	


function newAgrup(tip){timerAD(1,'timer2',0);
var nom=document.getElementById('newgrup').value;
var url='/ajax/newAgrup.php?nom=' + nom + '&tip=' + tip;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
var iframe = document.getElementById('agrupaciones');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;

if(key=='id'){
var lista=innerDoc.getElementById('agrupaciones');	
$(lista).append("<div class='agrup' id='" + val + "' onclick='selectAgrup(" + val + ")'><input type='text' value='" + nom + "' class='agrupados' onchange='modiAgrup(this.value)'></div>");
}

if(key=='error'){
alert(val);
}	

});
});		
timerAD(0,'timer2',0);
}

function modiAgrup(nom){
var idagr=document.getElementById('agrupSel').value;
var url='/ajax/updatefield.php?id=' + idagr + '&campo=nombre&tabla=agrupedidos&value=' + nom;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
});
});		

}

function autoagrupar(tip){$.ajaxSetup({'async': false});	
cargaAgrupados(tip,1);
var iframe = document.getElementById('pedipent');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('pedipent').innerHTML='';	
}



function detAgrupado(id,tip){$.ajaxSetup({'async': false});	
timerAD(1,'timer3',1);

var url='/ajax/actionPedidos.php?tip=' + tip + '&action=3&id=' + id;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var iframe = parent.document.getElementById('pediagrup');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
if(key=='html'){innerDoc.getElementById('pedipent').innerHTML=val;};		
	
});
});	

timerAD(0,'timer3',1);
	
}	





