window.debug =1;


function risa(){
if(window.top.bRISASA==1){window.top.bRISASA=0;}else{window.top.bRISASA=1;};

if(window.top.bRISASA==1){
document.getElementById('bRISASA').setAttribute("style", "background-color:#8DC29E;");	
document.getElementById('bRISASE').setAttribute("style", "background-color:none;");		
}else{
document.getElementById('bRISASE').setAttribute("style", "background-color:#8DC29E;");	
document.getElementById('bRISASA').setAttribute("style", "background-color:none;");			
}	

	
}

function botRD(b){

if(b=='rot'){

if((window.top.brot==1)&&(window.top.bdev==1)){window.top.brot=0;}else if(window.top.brot==0){window.top.brot=1;}	

}	

if(b=='dev'){
if((window.top.bdev==1)&&(window.top.brot==1)){window.top.bdev=0;}else if(window.top.bdev==0){window.top.bdev=1;}	

}


if(window.top.bdev==0){
document.getElementById('BotD').setAttribute("style", "background-color:none;");
}else{
document.getElementById('BotD').setAttribute("style", "background-color:#8DC29E;");	
}	


if(window.top.brot==0){
document.getElementById('BotR').setAttribute("style", "background-color:none;");
}else{
document.getElementById('BotR').setAttribute("style", "background-color:#8DC29E;");	
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





function tselALL(){
if(window.debug ==1) {console.log('window.top.tselALL: ' + window.top.tselALL); };
if(window.debug ==1) {console.log('window.top.tsel: '); console.info(window.top.tsel); };	

var tie=window.top.tsel;

if (window.top.tselALL==0){

window.top.tselALL=1;
for (var i = 0; i < tie.length; i++) {if(document.getElementById('idt_' + i)){	
window.top.tsel[i]=1;
document.getElementById('idt_' + i).setAttribute("style", "background-color:#8DC29E;");
}}
	
}else{

window.top.tselALL=0;
for (var i = 0; i < tie.length; i++) {if(document.getElementById('idt_' + i)){	
window.top.tsel[i]=0;
document.getElementById('idt_' + i).setAttribute("style", "background-color:white;");
}}
	
}




if(window.debug ==1) {console.log('window.top.tselALL: ' + window.top.tselALL); };
if(window.debug ==1) {console.log('window.top.tsel: '); console.info(window.top.tsel); };	
	
}



function dlT(id){
document.getElementById(id).value="";
document.getElementById(id).setAttribute("style", "color:#333333;");
}


function tabT(id){
var fech=document.getElementById(id).value;
if(fech.length==1){fech=fech + '/';};
if(fech.length==5){fech=fech.substr(0,4);};
var fech=fech.replace("//","/");
document.getElementById(id).value=fech;	
}

function informeM(t){
var temp=document.getElementById('temp').value
temp=temp.replace('t/aa','');


if((temp=="")||(temp.length<4)){
alert('Debe introducir una temporada válida');	
}else{

var url="/informes/iGastos.php?";	
	
url = url 

 + "&temp=" + temp 
 + "&tipo=" + t 
 + '&listador=1'; 

getDATA(url);



}	
	
}



function informePE(){

var ttss=""; var tn=0;
var tsel=window.top.tsel;
for (var i = 0; i < tsel.length; i++) {if(tsel[i]==1){
ttss=ttss + i + ','; tn++;
}}
if(tn==0){alert('Debe seleccionar alguna tienda.');}else{

var fini=document.getElementById('fini').value
var ffin=document.getElementById('ffin').value
fini=fini.replace('dd/mm/aaaa','');
ffin=ffin.replace('dd/mm/aaaa','');

if((fini=="")||(ffin=="")){
alert('Debe introducir un rango de fechas');	
}else{

var url="/informes/iPorEmp.php?";	
	
url = url 

 + "&fini=" + fini 
 + "&ffin=" + ffin  
 + "&ttss=" + ttss 
 + "&risase=" + window.top.bRISASA  
 + '&listador=1'; 

getDATA(url);


}
}

}


function manio(b,anio){

if(b==1){	if(window.top.A_1==0){window.top.A_1=anio;}else{window.top.A_1=0;};	 }	
if(b==2){	if(window.top.A_2==0){window.top.A_2=anio;}else{window.top.A_2=0;};	 }	
if(b==3){	if(window.top.A_3==0){window.top.A_3=anio;}else{window.top.A_3=0;};	 }		

if(window.top.A_1==0){document.getElementById('a1').setAttribute("style", "background-color:none;");}else{document.getElementById('a1').setAttribute("style", "background-color:orange;");}
if(window.top.A_2==0){document.getElementById('a2').setAttribute("style", "background-color:none;");}else{document.getElementById('a2').setAttribute("style", "background-color:orange;");}
if(window.top.A_3==0){document.getElementById('a3').setAttribute("style", "background-color:none;");}else{document.getElementById('a3').setAttribute("style", "background-color:orange;");}
	
	
}




function informeIA(){
console.log(window.top.A_1 + "," + window.top.A_2 + "," + window.top.A_3);
var ttss=""; var tn=0;
var tsel=window.top.tsel;
for (var i = 0; i < tsel.length; i++) {if(tsel[i]==1){
ttss=ttss + i + ','; tn++;
}}
if(tn==0){alert('Debe seleccionar alguna tienda.');}else{

var fini=document.getElementById('fini').value
var ffin=document.getElementById('ffin').value
fini=fini.replace('dd/mm','');
ffin=ffin.replace('dd/mm','');

if((fini=="")||(ffin=="")){
alert('Debe introducir un rango de fechas');	
}else{

var anios="";
if(window.top.A_1>0){anios=anios + window.top.A_1 + ",";};
if(window.top.A_2>0){anios=anios + window.top.A_2 + ",";};
if(window.top.A_3>0){anios=anios + window.top.A_3 + ",";};
 
if(anios==''){alert('Debe seleccionar por lo menos un año con el que comparar');}else{

var url="/informes/iinteranual.php?";	
	
url = url 

 + "&fini=" + fini 
 + "&ffin=" + ffin  
 + "&ttss=" + ttss 
 + "&anios=" + anios 
 + "&risase=" + window.top.bRISASA  
 + '&listador=1'; 

getDATA(url);

}
}
}

}





function informePV(){



var fini=document.getElementById('fini').value
var ffin=document.getElementById('ffin').value
fini=fini.replace('dd/mm/aaaa','');
ffin=ffin.replace('dd/mm/aaaa','');

if((fini=="")||(ffin=="")){
alert('Debe introducir un rango de fechas');	
}else{

var url="/informes/iPorcVent.php?";	
	
url = url 

 + "&fini=" + fini 
 + "&ffin=" + ffin  
 + "&risase=" + window.top.bRISASA  
 + '&listador=1'; 

getDATA(url);



}

}




function informeMB(){

var ttss=""; var tn=0;
var tsel=window.top.tsel;
for (var i = 0; i < tsel.length; i++) {if(tsel[i]==1){
ttss=ttss + i + ','; tn++;
}}
if(tn==0){alert('Debe seleccionar alguna tienda.');}else{

var fini=document.getElementById('fini').value
var ffin=document.getElementById('ffin').value
fini=fini.replace('dd/mm/aaaa','');
ffin=ffin.replace('dd/mm/aaaa','');

if((fini=="")||(ffin=="")){
alert('Debe introducir un rango de fechas');	
}else{

var url="/informes/iMargenBen.php?";	
	
url = url 

 + "&fini=" + fini 
 + "&ffin=" + ffin  
 + "&ttss=" + ttss 
 + "&risase=" + window.top.bRISASA  
 + '&listador=1'; 

getDATA(url);


}
}

}







function informePH(){

var ttss=""; var tn=0;
var tsel=window.top.tsel;
for (var i = 0; i < tsel.length; i++) {if(tsel[i]==1){
ttss=ttss + i + ','; tn++;
}}
if(tn==0){alert('Debe seleccionar alguna tienda.');}else{

var fini=document.getElementById('fini').value
var ffin=document.getElementById('ffin').value
fini=fini.replace('dd/mm/aaaa','');
ffin=ffin.replace('dd/mm/aaaa','');

if((fini=="")||(ffin=="")){
alert('Debe introducir un rango de fechas');	
}else{

var url="/informes/iPorHor.php?";	
	
url = url 

 + "&fini=" + fini 
 + "&ffin=" + ffin  
 + "&ttss=" + ttss 
 + "&risase=" + window.top.bRISASA  
 + '&listador=1'; 

getDATA(url);


}
}

}





function informeMES(){

var frqcia=1;

var ttss=""; var tn=0;
var tsel=window.top.tsel;
for (var i = 0; i < tsel.length; i++) {if(tsel[i]==1){
ttss=ttss + i + ','; tn++;
}}
if(tn==0){alert('Debe seleccionar alguna tienda.');}else{
var mes=document.getElementById('fini').value
mes=mes.replace('mm/aaaa','');

if(mes==""){
alert('Debe introducir un mes');	
}else{

var url="/informes/iMensual.php?";	
	
url = url 

 + "&mes=" + mes 
 + "&ttss=" + ttss 
 + "&risase=" + window.top.bRISASA  
 + "&frqcia=" + frqcia  
 + '&listador=1'; 

getDATA(url);


}
}

}

function informePD(){

var frqcia=1;
//if(document.getElementById('frqcia').checked){
//var frqcia=1;	
//}else{
//var frqcia=0;	
//}

var ttss=""; var tn=0;
var tsel=window.top.tsel;
for (var i = 0; i < tsel.length; i++) {if(tsel[i]==1){
ttss=ttss + i + ','; tn++;
}}
if(tn==0){alert('Debe seleccionar alguna tienda.');}else{
var mes=document.getElementById('fini').value
mes=mes.replace('mm/aaaa','');

if(mes==""){
alert('Debe introducir un mes');	
}else{

var url="/informes/iPordias.php?";	
	
url = url 

 + "&mes=" + mes 
 + "&ttss=" + ttss 
 + "&risase=" + window.top.bRISASA  
 + "&frqcia=" + frqcia  
 + '&listador=1'; 

getDATA(url);


}
}

}

function informeR(){

var ttss=""; var tn=0;
var tsel=window.top.tsel;
for (var i = 0; i < tsel.length; i++) {if(tsel[i]==1){
ttss=ttss + i + ','; tn++;
}}

if(tn==0){alert('Debe seleccionar alguna tienda.');}else{

var fini=document.getElementById('fini').value
var ffin=document.getElementById('ffin').value
fini=fini.replace('dd/mm/aaaa','');
ffin=ffin.replace('dd/mm/aaaa','');

if((fini=="")||(ffin=="")){
alert('Debe introducir un rango de fechas');	
}else{

var url="/informes/iRoturas.php?";	
	
url = url 

 + "&fini=" + fini 
 + "&ffin=" + ffin 
 + "&ttss=" + ttss 
 + "&rot=" + window.top.brot  
 + "&dev=" + window.top.bdev  
 + '&listador=1'; 

getDATA(url);


}
}

}









function informeG(d){


var prov=document.getElementById(2).value
var grup=document.getElementById(3).value
var subg=document.getElementById(4).value
var colo=document.getElementById(5).value
var codi=document.getElementById(6).value
var pvp=document.getElementById(7).value
var desd=document.getElementById(8).value
var hast=document.getElementById(9).value
var temp=document.getElementById(10).value
var detalles=document.getElementById(11).value
var comentarios=document.getElementById(12).value

if(document.getElementById('cong').checked){
var cong=1;	
}else{
var cong=0;	
}



if(d=='I'){
	var url="/informes/igeneral.php?";
}else{
	var url="/informes/igeneralA.php?";	
}
	var act=window.top.OrdV;
	var actO=window.top.OrdVO;
	



	
url = url 
 + "id_proveedor=" + prov
 + "&id_grupo=" + grup
 + "&id_subgrupo=" + subg
 + "&id_color=" + colo
 + "&codigo=" + codi
 + "&pvp=" + pvp
 + "&desde=" + desd
 + "&hasta=" + hast
 + "&temporada=" + temp 
 + "&comentarios=" + comentarios
 + "&detalles=" + detalles
 + "&act=" + act 
 + "&actO=" + actO 
 + "&cong=" + cong 
 + '&listador=1'; 




getDATA(url);


}












function informeVPT(){

var prov=document.getElementById(2).value
var grup=document.getElementById(3).value
var subg=document.getElementById(4).value
var colo=document.getElementById(5).value
var codi=document.getElementById(6).value
var pvp=document.getElementById(7).value
var desd=document.getElementById(8).value
var hast=document.getElementById(9).value
var temp=document.getElementById(10).value
var detalles=document.getElementById(11).value
var comentarios=document.getElementById(12).value

if(document.getElementById('fini')){
var fini=document.getElementById('fini').value
var ffin=document.getElementById('ffin').value
}else{
var fini="";
var ffin="";	
}


var act=window.top.VOrdV;
var actO=window.top.VOrdVO;

fini=fini.replace('dd/mm/aaaa','');
ffin=ffin.replace('dd/mm/aaaa','');

if((fini=="")||(ffin=="")){
alert('Debe introducir un rango de fechas');	
}else{


var url="/informes/informeVpT.php?";
	
	
url = url 
 + "id_proveedor=" + prov
 + "&id_grupo=" + grup
 + "&id_subgrupo=" + subg
 + "&id_color=" + colo
 + "&codigo=" + codi
 + "&pvp=" + pvp
 + "&desde=" + desd
 + "&hasta=" + hast
 + "&temporada=" + temp 
 + "&comentarios=" + comentarios
 + "&detalles=" + detalles
 + "&fini=" + fini 
 + "&ffin=" + ffin
 + "&risase=" + window.top.bRISASA   
 + "&act=" + act 
 + "&actO=" + actO 
 + '&listador=1'; 

getDATA(url);



}	
	
}





function informe(codigo){


var prov=document.getElementById(2).value
var grup=document.getElementById(3).value
var subg=document.getElementById(4).value
var colo=document.getElementById(5).value
var codi=document.getElementById(6).value
var pvp=document.getElementById(7).value
var desd=document.getElementById(8).value
var hast=document.getElementById(9).value
var temp=document.getElementById(10).value
var detalles=document.getElementById(11).value
var comentarios=document.getElementById(12).value

if(document.getElementById('fini')){
var fini=document.getElementById('fini').value
var ffin=document.getElementById('ffin').value
}else{
var fini="";
var ffin="";	
}

//document.getElementById(2).value="";
//document.getElementById(3).value="";
//document.getElementById(4).value="";
//document.getElementById(5).value="";
//document.getElementById(6).value="";
//document.getElementById(7).value="";
//document.getElementById(8).value="";
//document.getElementById(9).value="";
//document.getElementById(10).value="";
	


if(codigo=='ventas'){
	var url="/informes/hventas.php?";
	var act=window.top.OrdV;
	var actO=window.top.OrdVO;
	
	};

if(codigo=='valorado'){
	var url="/informes/hvalorado.php?";
	var act=window.top.VOrdV;
	var actO=window.top.VOrdVO;
	
	};

if(codigo=='descuadre'){
	var url="/informes/idescuadres.php?";
	var act=window.top.VOrdV;
	var actO=window.top.VOrdVO;
	
	};

	
url = url 
 + "id_proveedor=" + prov
 + "&id_grupo=" + grup
 + "&id_subgrupo=" + subg
 + "&id_color=" + colo
 + "&codigo=" + codi
 + "&pvp=" + pvp
 + "&desde=" + desd
 + "&hasta=" + hast
 + "&temporada=" + temp 
 + "&comentarios=" + comentarios
 + "&detalles=" + detalles
 + "&fini=" + fini 
 + "&ffin=" + ffin 
 + "&act=" + act 
 + "&actO=" + actO 
 + '&listador=1'; 


fini=fini.replace('dd/mm/aaaa','');
ffin=ffin.replace('dd/mm/aaaa','');

if(document.getElementById('fini')){
if((fini=="")||(ffin=="")){
alert('Debe introducir un rango de fechas');	
}else{
getDATA(url);
}}else{
getDATA(url);	
}

}




function getDATA(url){$.ajaxSetup({'async': false});
if(document.getElementById('mphotos')){document.getElementById('mphotos').setAttribute("style", "visibility:hidden;");};
if(window.debug ==1) {console.log('url: ' + url);};
document.getElementById('status').innerHTML="CALCULANDO";
document.getElementById('reloj').setAttribute("style", "visibility:visible;");

	$.getJSON(url, function(data) {
	$.each(data, function(key, val) {
	if(key=='ng'){
	
	if(val>0){
	var timeOFF=val*6;
	loadExcel(timeOFF);
	}else{
	alert('Los datos seleccionados, no generan resultados');
	document.getElementById('status').innerHTML="";
	document.getElementById('reloj').setAttribute("style", "visibility:hidden;");	
	}
	
	}
	
	});
	});	

	
	
}

function loadExcel(timeOFF){$.ajaxSetup({'async': false});
document.getElementById('status').innerHTML="RENDERIZANDO";
document.getElementById('excel').src='/informes/excel.php';
setTimeout('finCALC()', timeOFF);	
}


function finCALC(){$.ajaxSetup({'async': false});

document.getElementById('status').innerHTML="";
document.getElementById('reloj').setAttribute("style", "visibility:hidden;");
if(document.getElementById('mphotos')){document.getElementById('mphotos').setAttribute("style", "visibility:visible;");};

	
}


function popupPhotos(){

window.open('/informes/photos.php','1382091219155','width=500,height=700,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');


	
}



function orD(id){

document.getElementById('1|A').setAttribute("style", "visibility:hidden;");
document.getElementById('2|A').setAttribute("style", "visibility:hidden;");
document.getElementById('3|A').setAttribute("style", "visibility:hidden;");
document.getElementById('4|A').setAttribute("style", "visibility:hidden;");

document.getElementById('1|D').setAttribute("style", "visibility:hidden;");
document.getElementById('2|D').setAttribute("style", "visibility:hidden;");
document.getElementById('3|D').setAttribute("style", "visibility:hidden;");
document.getElementById('4|D').setAttribute("style", "visibility:hidden;");

var act=window.top.OrdV;
var actO=window.top.OrdVO;

if(id==act){if(actO=='A'){var nO='D';}else{var nO='A';}}else{var nO='D';};

window.top.OrdV=id;
window.top.OrdVO=nO;
document.getElementById(id + '|' + nO).setAttribute("style", "visibility:visible;");

	
	
}

function VorD(id){

document.getElementById('V|1|A').setAttribute("style", "visibility:hidden;");
document.getElementById('V|2|A').setAttribute("style", "visibility:hidden;");
document.getElementById('V|3|A').setAttribute("style", "visibility:hidden;");
document.getElementById('V|4|A').setAttribute("style", "visibility:hidden;");

document.getElementById('V|1|D').setAttribute("style", "visibility:hidden;");
document.getElementById('V|2|D').setAttribute("style", "visibility:hidden;");
document.getElementById('V|3|D').setAttribute("style", "visibility:hidden;");
document.getElementById('V|4|D').setAttribute("style", "visibility:hidden;");

var act=window.top.VOrdV;
var actO=window.top.VOrdVO;

if(id==act){if(actO=='A'){var nO='D';}else{var nO='A';}}else{var nO='D';};

window.top.VOrdV=id;
window.top.VOrdVO=nO;
document.getElementById('V|' + id + '|' + nO).setAttribute("style", "visibility:visible;");

	
	
}








