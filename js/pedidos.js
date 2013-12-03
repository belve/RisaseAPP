
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
if(document.getElementById('agrupSel')){var lastsel=document.getElementById('agrupSel').value;}else{lastsel=id;};
if(lastsel!=id){
if(lastsel!=''){document.getElementById(lastsel).setAttribute("style", "background-color:white;");};	
if(document.getElementById(id)){
document.getElementById(id).setAttribute("style", "background-color:#8DC29E;");		
document.getElementById('agrupSel').value=id;
detAgrupado(id,tip);
};
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
$(lista).append("<div class='agrup' id='" + val + "' onclick='selectAgrup(" + val + "," + tip + ")'>" + nom + "<div class='iconos trash' onclick='borra_agru(" + val + "," + tip + ")'></div> </div>");

var iframe = document.getElementById('FV2P1');
var V = iframe.contentDocument || iframe.contentWindow.document;
var addf="<div class='agrup_V2' id='" + val + "' onclick='selV2agrup(\"" + val + "|1\")'>" + nom + "</div>";
$(V).find('#agrupaciones').append(addf);

}

if(key=='error'){
alert(val);
}	

});
});		
timerAD(0,'timer2',0);
document.getElementById('newgrup').value="";
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
cargaAgrupados2(tip,0);	
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


function selALL(f){
var dblP=window.top.dblP;
var dblA=window.top.dblA;

if(f=='pediagrup'){
if(dblA==0){dblA=1;}else{dblA=0;};	
var doit=dblA;
}	


if(f=='pedipent'){
if(dblP==0){dblP=1;}else{dblP=0;};	
var doit=dblP;
}	


var iframe = document.getElementById(f);
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var maxF=innerDoc.getElementById('maxF').value; 

console.log('doit:' + doit);
console.log('maxF:' + maxF);

var sele="";
for (var a=1; a <= maxF; a++){
var cod=innerDoc.getElementById('F' + a).value;	
if(doit==0){
	innerDoc.getElementById(cod).setAttribute("style", "background-color:white;");sele="";
	}else{
	innerDoc.getElementById(cod).setAttribute("style", "background-color:#8DC29E;");
	sele=sele + cod + ",";		
	}
}

var lgth=sele.length;
if(lgth > 0) {var sele=sele.substr(0,(lgth-1));};

innerDoc.getElementById('artselected').value=sele; 

window.top.dblP=dblP;
window.top.dblA=dblA;
	
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
if (agrupacion!=''){
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

selectAgrup(agrupacion,tip);	
}else{alert('Debe seleccionar una agrupacion');}
}



function meteAgrup(tip){$.ajaxSetup({'async': false});	
var iframe = document.getElementById('agrupaciones');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var agrupacion=innerDoc.getElementById('agrupSel').value;	
if (agrupacion!=''){
var iframe = document.getElementById('pedipent');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var seleccionados=innerDoc.getElementById('artselected').value;

var url='/ajax/cambiaagrupa.php?tip=' + tip + '&oldG=' + '' + '&newG=' + agrupacion + '&selecion=' + seleccionados;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

		
	
});
});	




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

cargaPendientes(tip);
}else{alert('Debe seleccionar una agrupacion');}
}



function selPEST(p){
document.getElementById('pestaniasG').setAttribute("style", "visibility:hidden;");	
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



var tip=window.tipi;	
cargaAgrupados2(tip,0,"","");
if(p=='P1'){initP();};	
}


function selPEST_V2(p){
var estAct=document.getElementById(p).className;
var anti=document.getElementById('V2SEL').value;

if(document.getElementById('filtro').value!=''){
document.getElementById('filtro').value='';
var tip=document.getElementById('tip').value;
cargaAgrupados2(tip,0,"","");	
}

if(estAct=='V2_PEST_off'){
	
	
	
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

limpGagru(anti);
}






function filtro(tip){
var filtro=document.getElementById('filtro').value;	
var filtro=filtro.replace('%','|'); 
var v2p=document.getElementById('V2SEL').value;
if(v2p=="V2P1"){var est='P';};
if(v2p=="V2P2"){var est='A';};
if(v2p=="V2P3"){var est='T';};
if(v2p=="V2P4"){var est='F';};


console.log('tip: ' + tip + 'est: ' + est + 'filtro: ' + filtro);
cargaAgrupados2(tip,0,est,filtro);
//document.getElementById('filtro').value="";
document.getElementById('filtro').select();	
}

function cargaAgrupados2(tip,agrupar,est,filtro){	

var iframe = document.getElementById('FV2P1');
var A = iframe.contentDocument || iframe.contentWindow.document;
A.getElementById('agrupaciones').innerHTML='';

var iframe = document.getElementById('FV2P2');
var A = iframe.contentDocument || iframe.contentWindow.document;
A.getElementById('agrupaciones').innerHTML='';

var iframe = document.getElementById('FV2P3');
var A = iframe.contentDocument || iframe.contentWindow.document;
A.getElementById('agrupaciones').innerHTML='';

var iframe = document.getElementById('FV2P4');
var A = iframe.contentDocument || iframe.contentWindow.document;
A.getElementById('agrupaciones').innerHTML='';


var fP=0;var fA=0;var fT=0;var fF=0;
var url='/ajax/listAgrupV2.php?tip=' + tip + '&action=1&agrupar=' + agrupar + '&est=' + est  + '&filtro=' + filtro;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {


var str=val.toString();
var valu=str.replace(/,/g, '');


if((key=='P')&&(valu!='')){var fP=1;
	var iframe = document.getElementById('FV2P1');
	var P = iframe.contentDocument || iframe.contentWindow.document;
	P.getElementById('agrupaciones').innerHTML=valu;};
			
if((key=='A')&&(valu!='')){var fA=1;
	var iframe = document.getElementById('FV2P2');
	var A = iframe.contentDocument || iframe.contentWindow.document;
	A.getElementById('agrupaciones').innerHTML=valu;};
		
if((key=='T')&&(valu!='')){var fT=1;
	var iframe = document.getElementById('FV2P3');
	var T = iframe.contentDocument || iframe.contentWindow.document;
	T.getElementById('agrupaciones').innerHTML=valu;};	

if((key=='F')&&(valu!='')){var fF=1;
	var iframe = document.getElementById('FV2P4');
	var F = iframe.contentDocument || iframe.contentWindow.document;
	F.getElementById('agrupaciones').innerHTML=valu;};	

if((key=='filasP')&&(fP>0)){document.getElementById('nfV2P1').value=val;};	
if((key=='filasA')&&(fA>0)){document.getElementById('nfV2P2').value=val;};
if((key=='filasT')&&(fT>0)){document.getElementById('nfV2P3').value=val;};
if((key=='filasF')&&(fF>0)){document.getElementById('nfV2P4').value=val;};


	
});
});	


}





function selV2agrup(ida){
	
var valo=ida.split('|');var ida2=valo[0];	var v=valo[1];
var idag=parent.document.getElementById('ag_selected').value;	
if(idag!=ida2){

var lastPsel=parent.document.getElementById('ag_selected_P').value;	
if(lastPsel && (lastPsel!=parent.document.getElementById('V2SEL').value)){
var iframe = parent.document.getElementById('F' + lastPsel);
var V = iframe.contentDocument || iframe.contentWindow.document;
if(V.getElementById(idag)){V.getElementById(idag).setAttribute("style", "background-color:white;");};
}else{
if(idag){document.getElementById(idag).setAttribute("style", "background-color:white;");};	
}

document.getElementById(ida2).setAttribute("style", "background-color:#8DC29E;");
parent.document.getElementById('ag_selected').value=ida2;
parent.document.getElementById('ag_selected_P').value=parent.document.getElementById('V2SEL').value;
cargaGRIDagru(ida2);
}

parent.document.getElementById('pestaniasG').setAttribute("style", "visibility:visible;");
}



function limpGagru(anti){

var idag=document.getElementById('ag_selected').value;	

console.log('anti:' + anti);
var iframe = document.getElementById('F' + anti);
var V = iframe.contentDocument || iframe.contentWindow.document;

if(V.getElementById(idag)){V.getElementById(idag).setAttribute("style", "background-color:white;");};

	
var iframe = document.getElementById('GRID');
var GRID = iframe.contentDocument || iframe.contentWindow.document;	
GRID.getElementById('grid').innerHTML='';
if(document.getElementById('optCABE')){document.getElementById('optCABE').innerHTML='';};
pest_Cestado('',document);
document.getElementById('nagru').innerHTML='';
document.getElementById('ag_selected').value='';
document.getElementById('pestaniasG').setAttribute("style", "visibility:hidden;");	
}



function cargaGRIDagru(idag){$.ajaxSetup({'async': false});	

timerAD(1,'timer4',1);

var url='/ajax/listGRID.php?idagrupacion=' + idag;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
var iframe = parent.document.getElementById('GRID');
var GRID = iframe.contentDocument || iframe.contentWindow.document;	

if(key=='cabe'){parent.document.getElementById('optCABE').innerHTML=val;};
if(key=='roto'){roto(val);};
if(key=='html'){GRID.getElementById('grid').innerHTML=val;};
if(key=='nagru'){parent.document.getElementById('nagru').innerHTML=val;};
if(key=='estado'){pest_Cestado(val,parent.document);};
if(key=='maxfil'){GRID.getElementById('filas').value=val;};

});
});	
parent.document.getElementById('ag_selected').value=idag;
timerAD(0,'timer4',1);
	
}


function cargaPedGRID(){$.ajaxSetup({'async': false});	

timerAD(1,'timer4',0);

var url='/ajax/listGRID.php?idagrupacion=GRID';
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
var iframe = document.getElementById('GRID');
var GRID = iframe.contentDocument || iframe.contentWindow.document;	

if(key=='cabe'){document.getElementById('optCABE').innerHTML=val;};
//if(key=='roto'){roto(val);};
if(key=='html'){GRID.getElementById('grid').innerHTML=val;};
if(key=='new_fil'){window.top.GnewfilHTM=val;};
if(key=='maxfil'){window.top.Gmaxfil=val;};
//if(key=='nagru'){document.getElementById('nagru').innerHTML=val;};

});
});	

timerAD(0,'timer4',0);




}


function addfGrid(){

var cod=document.getElementById('cod').value;	

var url='/ajax/addCodtoGRID.php?cod=' + cod;

window.top.GnewfilHTM_2=window.top.GnewfilHTM;

$.getJSON(url, function(data) {
$.each(data, function(key, val) {

if(key=='error'){alert(val);};
if(key=='ida'){window.top.GnewfilHTM=window.top.GnewfilHTM.replace(/%ida%/g,val);window.top.idachk=val;};
if(key=='sto'){window.top.GnewfilHTM=window.top.GnewfilHTM.replace(/%sto%/g,val);};
if(key=='nom'){window.top.GnewfilHTM=window.top.GnewfilHTM.replace(/%nom%/g,val);};
if(key=='dr'){window.top.GnewfilHTM=window.top.GnewfilHTM.replace(/%dr%/g,val);};
if(key=='sto2'){window.top.GnewfilHTM=window.top.GnewfilHTM.replace(/%sto2%/g,val);};

});
});	

var fil=Number(window.top.Gmaxfil);
fil++;
window.top.GnewfilHTM=window.top.GnewfilHTM.replace(/%fil%/g,fil);

	
var iframe = document.getElementById('GRID');
var GRID = iframe.contentDocument || iframe.contentWindow.document;	


var cont=window.top.GnewfilHTM;


if(GRID.getElementById(window.top.idachk)){
alert ('Codigo ya listado en el grid');	
}else{
GRID.getElementById('grid').innerHTML=GRID.getElementById('grid').innerHTML + cont;
GRID.getElementById(fil + '-1').focus();
}

window.top.GnewfilHTM=window.top.GnewfilHTM_2;	
document.getElementById('cod').value="";
document.getElementById('cod').focus();	
}





function pest_Cestado(est,donde){
if(est=='E'){est='T';};
donde.getElementById('bot_imp').setAttribute("style", "visibility:hidden;");
if(est=='A'){donde.getElementById('bot_imp').setAttribute("style", "visibility:visible;");};
if(est=='T'){donde.getElementById('bot_imp').setAttribute("style", "visibility:visible;");};
if(est=='F'){donde.getElementById('bot_imp').setAttribute("style", "visibility:visible;");};

donde.getElementById('P_E_P').className="pG_estado_off";
donde.getElementById('P_E_A').className="pG_estado_off";
donde.getElementById('P_E_T').className="pG_estado_off";
donde.getElementById('P_E_F').className="pG_estado_off";

if(donde.getElementById('P_E_' + est)){
donde.getElementById('P_E_' + est).className="pG_estado_on";
}

donde.getElementById('est_sel_act').value=est;
}


function roto(rot){
window.top.roto=rot;
console.log('roto: ' + window.top.roto);	
}

function cambiaEst_agru(est,tip){$.ajaxSetup({'async': false});	

var iframe = document.getElementById('GRID');
var GRID = iframe.contentDocument || iframe.contentWindow.document;	
var filasg=GRID.getElementById('filas').value;

if((filasg==0)&&(est=='T')){alert('No es posible enviar a tienda agrupaciones vacias');}else{

var oldest=document.getElementById('est_sel_act').value;

if((oldest=='T')||(oldest=='F')){
	if ((est=='P')||(est=='A')){

alert('No es posible cambiar de estado una vez enviados a tienda o finalizados');	

 } }else{
 
var roturaT=window.top.roto;
console.log('roturaT: ' + roturaT + 'tip: ' + tip + ' est:' + est);

if((roturaT==1)&&(tip==1)&&(est=='T')){var nodo=1;}else{var nodo=0;}; 	

if(nodo==1){alert('No es posible enviar a tienda con artículos con rotura de stock');}else{ 	

if(est=='T'){var C=confirm("¿Esta seguro de que desea enviarlo a tiendas?");}else{var C=true;};
if(C){
document.getElementById('bot_imp').setAttribute("style", "visibility:hidden;");
if(est=='A'){document.getElementById('bot_imp').setAttribute("style", "visibility:visible;");};

var oldest=document.getElementById('est_sel_act').value;
timerAD(1,'timer4',0);
var idag=document.getElementById('ag_selected').value;	
if(est=='F'){alert('Los pedidos pasan a estado finalizado de forma automática');}else{
var url='/ajax/listAgrupV2.php?action=2&idag=' + idag + '&newest=' + est;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
});
});	
pest_Cestado(est,document);

if (oldest=='P'){vo='V2P1';};if (oldest=='A'){vo='V2P2';};if (oldest=='T'){vo='V2P3';};if (oldest=='F'){vo='V2P3';};
if (est=='P'){vn='V2P1';};if (est=='A'){vn='V2P2';};if (est=='T'){vn='V2P3';};if (est=='F'){vn='V2P3';};


borradepest(vo,idag);
creaenpest(vn,idag,tip);

}
timerAD(0,'timer4',0);

}

}}
cargaAgrupados2(tip,0,"","");
}

}

function creaenpest(v,idag,tip){
	

if(v=='V2P1'){
var nagru=document.getElementById('nagru').innerHTML;
var tip=document.getElementById('tip').value;	
var iframe = document.getElementById('agrupaciones');
var V = iframe.contentDocument || iframe.contentWindow.document;
var addf="<div onclick='selectAgrup(" + idag + "," + tip + ")' id='" + idag + "' class='agrup'>" + nagru + "<div class='iconos trash' onclick='borra_agru(" + idag + "," + tip + ")'> </div>";
$(V).find('#agrupaciones').append(addf);	
}		
	
	
var iframe = document.getElementById('F' + v);
var V = iframe.contentDocument || iframe.contentWindow.document;
var nagru=document.getElementById('nagru').innerHTML;
var nf=document.getElementById('nf' + v).value;
nf++;document.getElementById('nf' + v).value=nf;

document.getElementById('ag_selected_P').value=v;
var vent=v.replace('V2P', '');

var addf="<div class='agrup_V2' id='" + idag + "' onclick='selV2agrup(\"" + idag + "|" + vent + "\")'>" + nagru + "</div>";
$(V).find('#agrupaciones').append(addf);
V.getElementById(idag).setAttribute("style", "background-color:#8DC29E;");
}

function borradepest(v,idag){
if(v=='V2P1'){
var iframe = document.getElementById('agrupaciones');
var V = iframe.contentDocument || iframe.contentWindow.document;
if(V.getElementById('agrupSel').value==idag){

var iframe = document.getElementById('pediagrup');
var V = iframe.contentDocument || iframe.contentWindow.document;
V.getElementById('pedipent').innerHTML='';	
}	
	
var iframe = document.getElementById('agrupaciones');
var V = iframe.contentDocument || iframe.contentWindow.document;
V.getElementById('agrupSel').value='';

$(V).find('#' + idag).remove();		
}	
	
var iframe = document.getElementById('F' + v);
var V = iframe.contentDocument || iframe.contentWindow.document;

var nf=document.getElementById('nf' + v).value;
nf--;document.getElementById('nf' + v).value=nf;

fila='#' + idag;
$(V).find(fila).remove();		

}


function borra_agru(idag,tip){v='V2P1';$.ajaxSetup({'async': false});
var iframe = parent.document.getElementById('agrupaciones');
var V = iframe.contentDocument || iframe.contentWindow.document;
if(V.getElementById('agrupSel').value==idag){

var iframe = parent.document.getElementById('pediagrup');
var V = iframe.contentDocument || iframe.contentWindow.document;
V.getElementById('pedipent').innerHTML='';	
}	
	
var iframe = parent.document.getElementById('agrupaciones');
var V = iframe.contentDocument || iframe.contentWindow.document;
V.getElementById('agrupSel').value='';

$(V).find('#' + idag).remove();	


var iframe = parent.document.getElementById('F' + v);
var V = iframe.contentDocument || iframe.contentWindow.document;

var nf=parent.document.getElementById('nf' + v).value;
nf--;parent.document.getElementById('nf' + v).value=nf;

fila='#' + idag;
$(V).find(fila).remove();	

var ag_selected=parent.document.getElementById('ag_selected').value;
if(ag_selected==idag){
parent.document.getElementById('ag_selected').value="";	
var iframe = parent.document.getElementById('GRID');
var GRID = iframe.contentDocument || iframe.contentWindow.document;	
GRID.getElementById('grid').innerHTML='';
parent.document.getElementById('nagru').innerHTML='';
pest_Cestado('',parent.document);	
}
	

timerAD(1,'timer1',1);

var url='/ajax/cambiaagrupa.php?tip=' + tip + '&oldG=' + idag + '&newG=' + '' + '&selecion=all';
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
});
});		
	


var url='/ajax/actionPedidos.php?tip=' + tip + '&action=1';
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
var iframe = parent.document.getElementById('pedipent');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('artselected').value='';
if(key=='html'){innerDoc.getElementById('pedipent').innerHTML=val;};		
});
});	

timerAD(0,'timer1',1);


	
	
}






function impREPt(){
$.ajaxSetup({'async': false});
var idREP=document.getElementById('ag_selected').value;
var url="/xls/repartoTiendas.php?id=" + idREP;
timerAD(1,'timer',0);
document.getElementById('print').src=url;	
setTimeout("timerAD(0,'timer',0);",16000);
}


	
function impREP(){
$.ajaxSetup({'async': false});
var idREP=document.getElementById('ag_selected').value;
var url="/xls/reparto.php?id=" + idREP;
timerAD(1,'timer',0);
document.getElementById('print').src=url;	

setTimeout("timerAD(0,'timer',0);",16000);


}


function impPED(){
$.ajaxSetup({'async': false});
var idREP=document.getElementById('ag_selected').value;
var url="/xls/pedido.php?id=" + idREP;
timerAD(1,'timer',0);
document.getElementById('print').src=url;	

setTimeout("timerAD(0,'timer',0);",16000);


}

function roturas(tip){
$.ajaxSetup({'async': false});
var idREP=document.getElementById('ag_selected').value;
var url="/xls/roturas.php?tip=" + tip + "&idagru=" + idREP;
timerAD(1,'timer',0);
document.getElementById('print').src=url;	

setTimeout("timerAD(0,'timer',0);",6000);


}

function envALM(tip){$.ajaxSetup({'async': false});
timerAD(1,'timer1',0);	
	
var url="/ajax/envALM.php?tip=" + tip 

$.getJSON(url, function(data) {
$.each(data, function(key, val) {

	
});
});
selPEST('P2');	
timerAD(0,'timer1',0);	
}

function updtPed(idp,field){
	
var dats=field.split('-');
var fil=dats[0];
var ida=document.getElementById('fl-' +fil).value;
var idg=document.getElementById('idgf-' +fil).value;
var idt=document.getElementById('t-' +field).value;
var dr=document.getElementById('dr-' +fil).value;
var rep=0;	
	
var valor=document.getElementById(field).value;
var url="/ajax/updatePedido.php?idp=" + idp 
+ '&idt=' + idt
+ '&ida=' + ida
+ '&idg=' + idg
+ '&cant=' + valor;


$.getJSON(url, function(data) {
$.each(data, function(key, val) {
});
});


for (var i = 0; i < 30; i++) {if(document.getElementById(fil + '-' + i)){rep=rep+Number(document.getElementById(fil + '-' + i).value);};}


var stck=Number(document.getElementById('stck-' + ida).value);
var nst=stck-rep-dr;
document.getElementById('sto-' + ida).innerHTML=nst;
document.getElementById('rep-' + ida).innerHTML=rep;	

if(nst >= 0){
document.getElementById(ida).setAttribute("style", "background-color:white;");	
}else{
document.getElementById(ida).setAttribute("style", "background-color:#F8CDD9;");	
}

}




function moveFieldGRID(value){
		
	var i=$("*:focus").attr("id");
	
	
	
	var datos = i.split('-');
	var fila = datos[0]; var columna= datos[1];
	
	
	
	if(value=='left'){
		columna--;
		var nuevo=fila + "-" + columna;
		};
	
	if(value=='right'){
		columna++;
		var nuevo=fila + "-" + columna;
	};
	
	
	if(value=='up'){
		fila--;
		var nuevo=fila + "-" + columna;
	};
	
	if(value=='down'){
		fila++
		var nuevo=fila + "-" + columna;
		};	
	
	
	if(document.getElementById(nuevo)){
	var func= "$('#" + nuevo + "').focus();";
	setTimeout(func, 60);
	}

	
}





