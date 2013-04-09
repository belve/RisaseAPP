
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
innerDoc.getElementById('artselected').value='';
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
innerDoc.getElementById('artselected').value='';
if(key=='html'){innerDoc.getElementById('pedipent').innerHTML=val;};		
	
});
});	

timerAD(0,'timer3',1);
	
}	




function selART(idart){
var filas=[];var nohagas=0;var ini=0; var fin=0;
		
var ctrl=top.document.getElementById('crtl').value; 
var ini=document.getElementById('ini').value; 
var fin=document.getElementById('fin').value; 


if(ctrl==1){

	if(ini==0){document.getElementById('ini').value=document.getElementById('I' + idart).value;var nohagas=1;};
		
	if(ini>0){
	var fin=document.getElementById('I' + idart).value;
	var finB=fin;
	var iniB=ini;
	
	if(ini > fin){var fin2=ini; ini=fin; fin=fin2;};
	while (ini <= fin){filas.push(document.getElementById('F' + ini).value); ini++;}; 
	document.getElementById('ini').value=0;document.getElementById('fin').value=0;	
	}

}else{
	filas.push(idart);document.getElementById('ini').value=0;document.getElementById('fin').value=0;		
}

/*alert('ctrl:' + ctrl + '\n' + 'ini:' + iniB + '\n' + 'fin:' + finB + '\n');*/

if(nohagas==0){
	for (var i = 0; i < filas.length; i++) {
	if(filas[i]){
	var idart=filas[i];
	selecciona(idart);
	}}
}



}


function selecciona(idart){
var newlist='';
var artselected=document.getElementById('artselected').value; 
var art=artselected.split(',');
var esta=0;
	
for (var i = 0; i < art.length; i++) {
if(art[i]!=''){
	if(art[i]==idart){document.getElementById(idart).setAttribute("style", "background-color:white;");esta=1;}else{newlist=newlist + art[i] + ',';}
}	
}
			
if(esta==0){document.getElementById(idart).setAttribute("style", "background-color:#8DC29E;");newlist=newlist + idart + ',';};		

newlist=newlist.substr(0,(newlist.length)-1);
document.getElementById('artselected').value=newlist;
document.getElementById('ini').value=0;document.getElementById('fin').value=0;	
}




function sacaAgrup(tip){
var iframe = document.getElementById('agrupaciones');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var agrupacion=innerDoc.getElementById('agrupSel').value;	

var iframe = document.getElementById('pediagrup');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var seleccionados=innerDoc.getElementById('artselected').value;

var url='/ajax/cambiaagrupa.php?tip=' + tip + '&oldG=' + agrupacion + '&newG=' + '' + '&selecion=' + seleccionados;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

		
	
});
});	


cargaPendientes(tip);

timerAD(1,'timer3',0);

var url='/ajax/actionPedidos.php?tip=' + tip + '&action=3&id=' + agrupacion;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var iframe = document.getElementById('pediagrup');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('artselected').value='';
if(key=='html'){innerDoc.getElementById('pedipent').innerHTML=val;};		
	
});
});	

timerAD(0,'timer3',0);

	
}



function meteAgrup(tip){
var iframe = document.getElementById('agrupaciones');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var agrupacion=innerDoc.getElementById('agrupSel').value;	

var iframe = document.getElementById('pedipent');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var seleccionados=innerDoc.getElementById('artselected').value;

var url='/ajax/cambiaagrupa.php?tip=' + tip + '&oldG=' + '' + '&newG=' + agrupacion + '&selecion=' + seleccionados;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

		
	
});
});	


cargaPendientes(tip);

timerAD(1,'timer3',0);

var url='/ajax/actionPedidos.php?tip=' + tip + '&action=3&id=' + agrupacion;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var iframe = document.getElementById('pediagrup');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('artselected').value='';
if(key=='html'){innerDoc.getElementById('pedipent').innerHTML=val;};		
	
});
});	

timerAD(0,'timer3',0);

	
}



function selPEST(p){
var estAct=document.getElementById(p).className;
if(estAct=='PestaniaOFF'){


if(p=='P1'){
document.getElementById('DV2P1').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P2').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P3').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P4').setAttribute("style", "visibility:hidden;");	
}

if(p=='P2'){
document.getElementById('DV2P1').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P2').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P3').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P4').setAttribute("style", "visibility:hidden;");	
document.getElementById('V2P1').className="V2_PEST_off";	
document.getElementById('V2P2').className="V2_PEST_off";	
document.getElementById('V2P3').className="V2_PEST_off";	
document.getElementById('V2P4').className="V2_PEST_off";

var V2=document.getElementById('V2SEL').value;
document.getElementById('D' + V2).setAttribute("style", "visibility:visible;");
document.getElementById(V2).className="V2_PEST_on";
}


document.getElementById('P1').className="PestaniaOFF";	
document.getElementById('P2').className="PestaniaOFF";	

document.getElementById('VP1').setAttribute("style", "visibility:hidden !important;");
document.getElementById('VP2').setAttribute("style", "visibility:hidden !important;");

document.getElementById(p).className="PestaniaON";	
document.getElementById('V' + p).setAttribute("style", "visibility:visible !important;");
	
	
	
}	
}


function selPEST_V2(p){
var estAct=document.getElementById(p).className;



if(estAct=='V2_PEST_off'){
	

if(p=='V2P1'){
var iframe = document.getElementById('FV2P1');
var P = iframe.contentDocument || iframe.contentWindow.document;
var filas=document.getElementById('nfV2PP').value;
}

if(p=='V2P2'){
var iframe = document.getElementById('FV2P2');
var P = iframe.contentDocument || iframe.contentWindow.document;
var filas=document.getElementById('nfV2PA').value;
}

if(p=='V2P3'){
var iframe = document.getElementById('FV2P3');
var P = iframe.contentDocument || iframe.contentWindow.document;
var filas=document.getElementById('nfV2PT').value;
}

if(p=='V2P4'){
var iframe = document.getElementById('FV2P4');
var P = iframe.contentDocument || iframe.contentWindow.document;
var filas=document.getElementById('nfV2PF').value;
}


for (var i = 1; i <= filas; i++){P.getElementById(i).setAttribute("style", "background-color:white;");}	
	
	
	
document.getElementById('V2P1').className="V2_PEST_off";	
document.getElementById('V2P2').className="V2_PEST_off";	
document.getElementById('V2P3').className="V2_PEST_off";	
document.getElementById('V2P4').className="V2_PEST_off";

document.getElementById('DV2P1').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P2').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P3').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P4').setAttribute("style", "visibility:hidden;");

document.getElementById('V2SEL').value=p;
document.getElementById(p).className="V2_PEST_on";	
document.getElementById('D' + p).setAttribute("style", "visibility:visible;");	
	
}	
}








function cargaAgrupados2(tip,agrupar){	





var url='/ajax/listAgrupV2.php?tip=' + tip + '&action=1&agrupar=' + agrupar;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {


var str=val.toString();
var valu=str.replace(/,/g, '');

if(key=='P'){
	var iframe = document.getElementById('FV2P1');
	var P = iframe.contentDocument || iframe.contentWindow.document;
	P.getElementById('agrupaciones').innerHTML=valu;};
			
if(key=='A'){
	var iframe = document.getElementById('FV2P2');
	var A = iframe.contentDocument || iframe.contentWindow.document;
	A.getElementById('agrupaciones').innerHTML=valu;};
		
if(key=='T'){
	var iframe = document.getElementById('FV2P3');
	var T = iframe.contentDocument || iframe.contentWindow.document;
	T.getElementById('agrupaciones').innerHTML=valu;};	

if(key=='F'){
	var iframe = document.getElementById('FV2P4');
	var F = iframe.contentDocument || iframe.contentWindow.document;
	F.getElementById('agrupaciones').innerHTML=valu;};	

if(key=='filasP'){document.getElementById('nfV2PP').value=val;};	
if(key=='filasA'){document.getElementById('nfV2PA').value=val;};
if(key=='filasT'){document.getElementById('nfV2PT').value=val;};
if(key=='filasF'){document.getElementById('nfV2PF').value=val;};


	
});
});	


}





function selV2agrup(ida){
var valo=ida.split('|');var idag=valo[0];	var v=valo[1];
var id=document.getElementById('IDA-' + idag).value;
var filas=parent.document.getElementById('nfV2P' + v).value;
for (var i = 1; i <= filas; i++){document.getElementById(i).setAttribute("style", "background-color:white;");}
document.getElementById(id).setAttribute("style", "background-color:#8DC29E;");

cargaGRIDagru(idag);

}


function cargaGRIDagru(idag){$.ajaxSetup({'async': false});	

timerAD(1,'timer4',1);

var url='/ajax/listGRID.php?idagrupacion=' + idag;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

if(key=='html'){
var iframe = parent.document.getElementById('GRID');
var GRID = iframe.contentDocument || iframe.contentWindow.document;		
GRID.getElementById('grid').innerHTML=val;
	
}

});
});	

timerAD(0,'timer4',1);
	
}











