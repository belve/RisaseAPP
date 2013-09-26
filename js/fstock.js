// window.top.listArts ='';
// window.top.select   ='';
// window.top.codbars 	= new Array();
// window.top.fijo 	= new Array();
// window.top.tienda	= new Array();	
window.debug =1;




function addArts(url){$.ajaxSetup({'async': false});

window.lArts = new Array();
window.cdbar = new Array();
window.nfij = new Array();
window.ntie = new Array();
window.sel = new Array();


	$.getJSON(url, function(data) {
	$.each(data, function(key, val) {
	
		window.lArts.push(key);
		window.cdbar.push(val);
		window.sel.push(1);
		
	if(window.top.listArts.indexOf(key) >= 0){
		window.nfij.push(window.top.fijo[window.top.listArts.indexOf(key)]); 
		window.ntie.push(window.top.tienda[window.top.listArts.indexOf(key)]); 
		}else{
		window.nfij.push('');
		window.ntie.push('');	
		}
	
	
	});
	});	
	
window.top.listArts=window.lArts;
window.top.codbars=window.cdbar;
window.top.fijo=window.nfij;
window.top.tienda=window.ntie;	
window.top.select=window.sel;		
	
if(window.debug ==1) {console.log('listArts: '); console.info(window.top.listArts); };	
if(window.debug ==1) {console.log('codbars: '); console.info(window.top.codbars); };	

refresh();

timer(0);	
}	



function refresh(){

var art=window.top.listArts;
var cod=window.top.codbars;
var fij=window.top.fijo;
var tie=window.top.tienda;	
var htm="";

for (var i = 0; i < art.length; i++) {

var count=i;

idA=art[i]; 	
idC=cod[i]; 	
pf=fij[i]; 	
ps=tie[i]; 	



htm=htm + 
"<tr id='TR_" + count +"'><td style='width:70px' id='F_" + count +"' onclick='selFil(this.id);' ><input type='text' class='camp_REBA_codbar' value='" + idC + "' style='width:80px' readonly tabindex='-1'></td>" + 
"<td style='width:45px'><input type='text' class='camp_REBA_codbar' tabindex='1 " + count+1 +"'  value='"+ pf +"' id='f_" + count +"'	style='width:40px; text-align:right;' onchange='javascript:chFIX(this.id,this.value);'	></td>" + 
"<td style='width:45px'><input onclick='select(this);' tabindex='2 " + count+1 +"' type='text' class='camp_REBA_codbar' value='"+ ps +"'	id='s_" + count +"' onchange='javascript:chSUM(this.id,this.value);'	style='width:40px; text-align:right;'></td>" + 
"<input type='hidden' id='c_" + count +"' value='"+ idA +"'></tr>";	


}

var iframe = document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('tabReb').innerHTML=htm;		



sel2();



	
}


function selFil(idt){
id=idt.replace('F_','');

if(window.debug ==1) {console.log('idt:' + idt); };	
if(window.debug ==1) {console.log('id: ' + id); };	
	
if(window.top.select[id]==1){window.top.select[id]=2;}else{window.top.select[id]=1;};

if(window.debug ==1) {console.log('select: '); console.info(window.top.select); };	

sel1();

}

function seltodsR(){
var sel=window.top.select;
for (var i = 0; i < sel.length; i++) {
window.top.select[i]=2;	
}	
sel2();	
}

function borraselR(){
	
var seli=window.top.select;

lArts = new Array();
cdbar = new Array();
nfij = new Array();
ntie = new Array();
sel = new Array();

for (var i = 0; i < seli.length; i++) {

if(seli[i]==1){

lArts.push(window.top.listArts[i]);
cdbar.push(window.top.codbars[i]);
nfij.push(window.top.fijo[i]);
ntie.push(window.top.tienda[i]);
sel.push(1);
	
}	


}

window.top.listArts=lArts;
window.top.codbars=cdbar;
window.top.fijo=nfij;
window.top.tienda=ntie;	
window.top.select=sel;	

refresh();		
}


function chFIX(camp,val){
var id=camp.replace('f_','');
window.top.fijo[id]=val;

document.getElementById('s_' +id).value='';	
window.top.tienda[id]='';
}

function fix(){
var val=document.getElementById('amount').value
val=val.replace('+','');
val=val.replace('-','');
var fij=window.top.fijo;	
for (var i = 0; i < fij.length; i++) {
window.top.fijo[i]=val;
window.top.tienda[i]='';
}	
refresh();		
}

function sum(){
var val=document.getElementById('amount').value
val=val.replace('+','');
val=val.replace('-','');
var fij=window.top.fijo;	
for (var i = 0; i < fij.length; i++) {
window.top.fijo[i]='';
window.top.tienda[i]='+' + val;
}	
refresh();		
}


function res(){
var val=document.getElementById('amount').value
val=val.replace('+','');
val=val.replace('-','');
var fij=window.top.fijo;	
for (var i = 0; i < fij.length; i++) {
window.top.fijo[i]='';
window.top.tienda[i]='-' + val;
}	
refresh();		
}



function chSUM(camp,val){
nval=val.replace('+','');
nval=val.replace('-','');
var id=camp.replace('s_','');

if(nval==val){
val='+' + val;
document.getElementById('s_' +id).value=val;		
}
	

window.top.tienda[id]=val;

document.getElementById('f_' +id).value='';	
window.top.fijo[id]='';
}








function sel1(){

var sel=window.top.select;
for (var i = 0; i < sel.length; i++) {	

		if(sel[i]==1){
		document.getElementById('TR_' + i).setAttribute("style", "background-color:white;");
		}else{
		document.getElementById('TR_' + i).setAttribute("style", "background-color:#8DC29E;");	
		}

}		
	
}



function sel2(){
var iframe = document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;

var sel=window.top.select;
for (var i = 0; i < sel.length; i++) {	

		if(sel[i]==1){
		innerDoc.getElementById('TR_' + i).setAttribute("style", "background-color:white;");
		}else{
		innerDoc.getElementById('TR_' + i).setAttribute("style", "background-color:#8DC29E;");	
		}

}		
	
}






function cajtie(idt){
	
if(window.top.tsel[idt]==0){window.top.tsel[idt]=1;}else{window.top.tsel[idt]=0;};	

var tie=window.top.tsel;
for (var i = 0; i < tie.length; i++) {if(document.getElementById('idt_' + i)){	
	
	if(tie[i]==0){
		document.getElementById('idt_' + i).setAttribute("style", "background-color:white;");
		}else{
		document.getElementById('idt_' + i).setAttribute("style", "background-color:#8DC29E;");	
		}

	
}}	
	
}



function enviaTiendas(){


var art=window.top.listArts;
var cod=window.top.codbars;
var fij=window.top.fijo;
var tie=window.top.tienda;
var tsel=window.top.tsel;
	
var artic=""; var ttss="";

for (var i = 0; i < art.length; i++) {
idA=art[i]; 	
idC=cod[i]; 	
pf=fij[i]; 	
ps=tie[i]; 
artic=artic + '&arts[' + idA + '][f]=' + pf;
artic=artic + '&arts[' + idA + '][s]=' + ps;
}

for (var i = 0; i < tsel.length; i++) {if(tsel[i]==1){
ttss=ttss + '&tsel[]=' + i;
}}




url='/ajax/insFIJstock.php?h=1' + artic + ttss;

if(window.debug ==1) {console.log('url: ' + url);  };	
	$.getJSON(url, function(data) {
	$.each(data, function(key, val) {
	alert(val);
	});
	});	

}












