window.debug =1;


$.ajaxSetup({'async': false});
function getCookieT(c_name){
if(window.debug ==1) {console.log('L4 : getCookieT(c_name);c_name='+ c_name);};

var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
{
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}

function setCookieT(c_name,value,exdays){
if(window.debug ==1) {console.log('L19 : setCookieT(c_name,value,exdays);value='+ value);};

var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString()) + "; path=/";
document.cookie=c_name + "=" + c_value;
}


function getArtfrBD(id){$.ajaxSetup({'async': false});
if(window.debug ==1) {console.log('L29 : getArtfrBD(id);id='+ id);};
var ocultos="";
var arts=window.top.listArts[id]; //document.getElementById('art_' + id).value;
var url="/ajax/getRbfromDB.php?id_rebaja=" + id;

$.getJSON(url, function(data) {
$.each(data, function(key, val) {
var datos=new Array();
var limp=arts.replace(key,'');

if(limp==arts){
arts=arts + " " + key;

var datos=val.split('|');

var idc=datos[0];
var idp=datos[1];
var idr=datos[2];


//document.getElementById('art_' + id).value
window.top.listArts[id]=arts; 									if(window.debug ==1) {console.log('L50 : INS REB_ACT|(art_' + id + ') : '+ arts);};

var iframe = parent.document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;

innerDoc.getElementById('ocultos').innerHTML=innerDoc.getElementById('ocultos').innerHTML + 
"<div id='oc_" + key + "' >" + 
"<input type='hidden' id='" + id + "_i_" + key + "' value='" + key + "'>" + 
"<input type='hidden' id='" + id + "_c_" + key + "' value='" + idc + "'>" + 
"<input type='hidden' id='" + id + "_p_" + key + "' value='" + idp + "'>" + 
"<input type='hidden' id='" + id + "_r_" + key + "' value='" + idr + "'> </div>";
}


});
});	
	
}

function addArticREB(url){$.ajaxSetup({'async': false});
if(window.debug ==1) {console.log('L68 : addArticREB(url);url='+ url); console.debug(window.top.listArts);};
var id=	document.getElementById('idrebaja').value;
var ocultos="";
var iframe = document.getElementById('FrebAct');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var arts=window.top.listArts[id]; //innerDoc.getElementById('art_' + id).value;


$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var datos=new Array();
var limp=arts.replace(key,'');

if(limp==arts){
arts=arts + " " + key;

var datos=val.split('|');

var idc=datos[0];
var idp=datos[1];
var idr=datos[2];

var iframe = document.getElementById('FrebAct');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;

//innerDoc.getElementById('art_' + id).value
window.top.listArts[id]=arts; 						

var iframe = document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;

innerDoc.getElementById('ocultos').innerHTML=innerDoc.getElementById('ocultos').innerHTML + 
"<div id='oc_" + key + "' >" + 
"<input type='hidden' id='" + id + "_i_" + key + "' value='" + key + "'>" + 
"<input type='hidden' id='" + id + "_c_" + key + "' value='" + idc + "'>" + 
"<input type='hidden' id='" + id + "_p_" + key + "' value='" + idp + "'>" + 
"<input type='hidden' id='" + id + "_r_" + key + "' value='" + idr + "'> </div>";
}






});
});	

if(window.debug ==1) {console.log('L114 : REB_ACT|(art_' + id + ') : '+ window.top.listArts[id]);}; //innerDoc.getElementById('art_' + id).value
ordencodigos(1);

}






function getRebC_htm2(id){$.ajaxSetup({'async': false});
if(window.debug ==1) {console.log('L122 : getRebC_htm2(id);id='+ id);};


var arts=window.top.listArts[id]; //innerDoc.getElementById('art_' + id).value;

var htm="";var count=0;

var iframe = document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;


art=arts.split(' ');

for (var i = 0; i < art.length; i++) {if(art[i]>0){count++;
idA=art[i]; 	

idC  =innerDoc.getElementById(id + '_c_' + idA).value;
idpvp=innerDoc.getElementById(id + '_p_' + idA).value;
idpre=innerDoc.getElementById(id + '_r_' + idA).value;



htm=htm + 
"<tr id='TR_" + count +"'><td style='width:70px' id='F_" + count +"' onclick='selFil(this.id);' ><input type='text' class='camp_REBA_codbar' value='" + idC + "' style='width:80px' readonly></td>" + 
"<td style='width:45px'><input type='text' class='camp_REBA_codbar' value='"+ idpvp +"' id='p_" + count +"'	style='width:40px; text-align:right;' readonly></td>" + 
"<td style='width:45px'><input onclick='select(this);' tabindex='" + count +"' type='text' class='camp_REBA_codbar' value='"+ idpre +"'	id='" + count +"' onchange='javascript:chunip(this.id);'	style='width:40px; text-align:right;'></td>" + 
"<input type='hidden' id='c_" + count +"' value='"+ idA +"'></tr>";	



}}

var val = new Array();
val[0] = count;
val[1] = htm;

//alert(htm);


var iframe = document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('tabReb').innerHTML=htm;	
innerDoc.getElementById('total').value=count;	
window.top.select[id]="";
document.getElementById("timer").style.visibility = "hidden";	
}




function refrescaSel(){
if(window.debug ==1) {console.log('L122 : refrescaSel()');};	
var total=document.getElementById('total').value;
var id=parent.document.getElementById('idrebaja').value
var select=window.top.select[id];
	
for (var i = 1; i <= total; i++){
	document.getElementById('TR_' + i).setAttribute("style", "background-color:white;");	
}
var sels=select.split(' ');

for (var i = 0; i < sels.length; i++){
	if( document.getElementById('TR_' + sels[i]) ){
		document.getElementById('TR_' + sels[i]).setAttribute("style", "background-color:#8DC29E;");
}}	
}


function selFil(fil){
if(window.debug ==1) {console.log('L191 : selFil(fil);fil='+ fil);};
var id=fil.replace('F_','');	
var idr=parent.document.getElementById('idrebaja').value
var select=window.top.select[idr];

var noselect=select.replace(id + " ",'');
if(select==noselect){
	select=select + id + " ";
	window.top.select[idr]=select;
	}else{
	window.top.select[idr]=noselect;	
	}



refrescaSel();


}

function seltodsR(){
if(window.debug ==1) {console.log('L210 : seltodsR();');};
var iframe = document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;	
	
var total=innerDoc.getElementById('total').value;
var select='';		
for (var i = 1; i <= total; i++){
select=select + i + " ";
}	
var idr=document.getElementById('idrebaja').value
window.top.select[idr]=select;	

refrescaSelTOP();	
}


function borraselR(){
if(window.debug ==1) {console.log('L226 :borraselR();');};	
var id=document.getElementById('idrebaja').value

var arts=' ' + window.top.listArts[id]; //innerDoc.getElementById('art_' + id).value;

var iframe = document.getElementById('articulos');
var innerDoc2 = iframe.contentDocument || iframe.contentWindow.document;

	
var select=window.top.select[id]; //innerDoc2.getElementById('select').value;	

var sels=select.split(' ');
var count=0;


for (var i = 0; i < sels.length; i++){
if(innerDoc2.getElementById('c_' + sels[i])){
	
count++;
var cod=innerDoc2.getElementById('c_' + sels[i]).value;
if(window.debug ==1) {console.log('arts=|'+ arts + '|');};
arts=arts.replace(' ' + cod,'');
innerDoc2.getElementById("oc_" +  cod).remove();

}}


//innerDoc.getElementById('art_' + id).value
window.top.listArts[id]=arts;

if(window.debug ==1) {console.log('L254 : REB_ACT|(art_' + id + ') : '+ window.top.listArts[id] );}; //innerDoc.getElementById('art_' + id).value
window.top.select[id]='';

innerDoc2.getElementById('total').value=innerDoc2.getElementById('total').value - count;
ordencodigos(1);
}


function tselALL(){
if(window.debug ==1) {console.log('L277 :tselALL();');};	

var id=document.getElementById('idrebaja').value;	

var iframe = document.getElementById('FrebAct');
var innerDoc2 = iframe.contentDocument || iframe.contentWindow.document;
var ta=innerDoc2.getElementById('ta_' + id).value;	
var tdt=innerDoc2.getElementById('tdt').value;
var tdts=tdt.split(' ');

if(ta==0){

for (var i = 0; i < tdts.length; i++){
document.getElementById('idt_' + tdts[i]).setAttribute("style", "background-color:#8DC29E;");	
}	
innerDoc2.getElementById('t_' + id).value=tdt;
innerDoc2.getElementById('ta_' + id).value=1;	


}else{
	
for (var i = 0; i < tdts.length; i++){
document.getElementById('idt_' + tdts[i]).setAttribute("style", "background-color:white;");	
}	
innerDoc2.getElementById('t_' + id).value='';
innerDoc2.getElementById('ta_' + id).value=0;
	
}


}





function refrescaSelTOP(){
if(window.debug ==1) {console.log('L257 :refrescaSelTOP();');};	

var id=document.getElementById('idrebaja').value	
var iframe = document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;		
var total=innerDoc.getElementById('total').value;
var select=window.top.select[id];
	
for (var i = 1; i <= total; i++){
	innerDoc.getElementById('TR_' + i).setAttribute("style", "background-color:white;");	
}
var sels=select.split(' ');

for (var i = 0; i < sels.length; i++){
	if( innerDoc.getElementById('TR_' + sels[i]) ){
		innerDoc.getElementById('TR_' + sels[i]).setAttribute("style", "background-color:#8DC29E;");
}}	
}




function getRebC_htm(id){$.ajaxSetup({'async': false});
if(window.debug ==1) {console.log('L279 :getRebC_htm(id);id='+ id);};



var arts=window.top.listArts[id]; //document.getElementById('art_' + id).value;
var htm="";var count=0;

var iframe = parent.document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;


art=arts.split(' ');

for (var i = 0; i < art.length; i++) {if(art[i]>0){count++;
idA=art[i]; 	
idC  =innerDoc.getElementById(id + '_c_' + idA).value;
idpvp=innerDoc.getElementById(id + '_p_' + idA).value;
idpre=innerDoc.getElementById(id + '_r_' + idA).value;



htm=htm + 
"<tr id='TR_" + count +"'><td style='width:70px' id='F_" + count +"' onclick='selFil(this.id);' ><input type='text' class='camp_REBA_codbar' value='" + idC + "' style='width:80px' readonly></td>" + 
"<td style='width:45px'><input type='text' class='camp_REBA_codbar' value='"+ idpvp +"' id='p_" + count +"'	style='width:40px; text-align:right;' readonly></td>" + 
"<td style='width:45px'><input onclick='select(this);' tabindex='" + count +"' type='text' class='camp_REBA_codbar' value='"+ idpre +"'	id='" + count +"' onchange='javascript:chunip(this.id);'	style='width:40px; text-align:right;'></td>" + 
"<input type='hidden' id='c_" + count +"' value='"+ idA +"'></tr>";	



}}

var val = new Array();
val[0] = count;
val[1] = htm;

//alert(htm);


var iframe = parent.document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('tabReb').innerHTML=htm;	
innerDoc.getElementById('total').value=count;
window.top.select[id]="";	
parent.document.getElementById("timer").style.visibility = "hidden";

}


function resetwindow(){
parent.document.getElementById('idrebaja').value='';	
parent.document.getElementById('amount').value='';

var iframe = parent.document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('tabReb').innerHTML='';	


var tiendst=document.getElementById('tdt').value;
if(tiendst){
var ti=tiendst.split(' ');
for (var i = 0; i < ti.length; i++) {parent.document.getElementById('idt_' + ti[i]).setAttribute("style", "background-color:white;");};
}
	
parent.document.getElementById('h2').value='';
parent.document.getElementById('h3').value='';
parent.document.getElementById('h4').value='';
parent.document.getElementById('h5').value='';
parent.document.getElementById('h6').value='';
parent.document.getElementById('h7').value='';
parent.document.getElementById('h8').value='';
parent.document.getElementById('h9').value='';
parent.document.getElementById('h10').value='';

parent.document.getElementById('2').value='';
parent.document.getElementById('3').value='';
parent.document.getElementById('4').value='';
parent.document.getElementById('5').value='';
parent.document.getElementById('6').value='';
parent.document.getElementById('7').value='';
parent.document.getElementById('8').value='';
parent.document.getElementById('9').value='';
parent.document.getElementById('10').value='';


}


function selReb(id,todos){
if(window.debug ==1) {console.log('L191 :selReb(id,todos);id='+ id + " todos=" + todos);};
	
if(parent.document.getElementById('idrebaja').value==id){
resetwindow();
document.getElementById(id).setAttribute("style", "background-color:white;");	
}else{
	
var iframe = parent.document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;	
window.top.select[id]='';	
	
	
parent.document.getElementById("timer").style.visibility = "visible";	
var art=todos.split(',');
for (var i = 0; i < art.length; i++) {
if(art[i]!=''){	
	if(document.getElementById(art[i])){
	document.getElementById(art[i]).setAttribute("style", "background-color:white;");};
	}
}	
document.getElementById(id).setAttribute("style", "background-color:#8DC29E;");
parent.document.getElementById('idrebaja').value=id;


var arts=window.top.listArts[id]; //document.getElementById('art_' + id).value;
if(!arts){getArtfrBD(id);}
ordencodigos(2);





parent.document.getElementById('fini').value=document.getElementById('i_' + id).value;
parent.document.getElementById('ffin').value=document.getElementById('f_' + id).value;


var tiendst=document.getElementById('tdt').value;
parent.document.getElementById('tisel').value="";
if(tiendst){
var ti=tiendst.split(' ');
for (var i = 0; i < ti.length; i++) {parent.document.getElementById('idt_' + ti[i]).setAttribute("style", "background-color:white;");};
}


var tiends=document.getElementById('t_' + id).value;
parent.document.getElementById('tisel').value=tiends;
if(tiends){
var tie=tiends.split(' ');
for (var i = 0; i < tie.length; i++) {parent.document.getElementById('idt_' + tie[i]).setAttribute("style", "background-color:#8DC29E;");};
}
parent.document.getElementById("timer").style.visibility = "hidden";

}
}


function cajtie(idt){
if(window.debug ==1) {console.log('L375 :cajtie(idt);idt='+ idt);};
	
var id=document.getElementById('idrebaja').value;	
var iframe = document.getElementById('FrebAct');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;	
var sels=innerDoc.getElementById('t_' + id).value;

var estaba=0;var newsel="";
if(sels){
	
var ti=sels.split(' ');
for (var i = 0; i < ti.length; i++) {
if(ti[i]==idt){var estaba=1;
document.getElementById('idt_' + ti[i]).setAttribute("style", "background-color:white;");	
}else{
newsel=newsel + ti[i] + " ";	
}
}
}

if (estaba==0){
newsel=newsel + idt + " ";
document.getElementById('idt_' + idt).setAttribute("style", "background-color:#8DC29E;");	
}	
newsel=newsel.replace(/^\s+/g,'').replace(/\s+$/g,'');
innerDoc.getElementById('t_' + id).value=newsel;

	

}

function chunip(i){
if(window.debug ==1) {console.log('L408 :chunip(i);i='+ i);};	
var precio=	document.getElementById(i).value;
var precio=Number(precio);
var precio = precio.toFixed(2);
var id_rebaja=parent.document.getElementById('idrebaja').value;	
var ida=document.getElementById('c_' + i).value;
document.getElementById(id_rebaja + '_r_' + ida).value=precio;
document.getElementById(i).value=precio;
}


function chPrice(h){
if(window.debug ==1) {console.log('L419 :chPrice(h);h='+ h);};	
var amount=document.getElementById('amount').value;
var amount=Number(amount);
var id_rebaja=document.getElementById('idrebaja').value;
var iframe = document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
total=innerDoc.getElementById('total').value;	

for (var i = 1; i <= total; i++) {
var pact=innerDoc.getElementById(i).value;
var pact=Number(pact);


if (h==1){pact=pact - ((pact/100)*amount)*1; };
if (h==2){pact=pact + ((pact/100)*amount)*1; };

if (h==3){pact=pact - (amount*1);};
if (h==4){pact=pact + (amount*1);};

if (h==5){pact=(amount*1); };


var pact = pact.toFixed(2);
innerDoc.getElementById(i).value=pact;
var ida=innerDoc.getElementById('c_' + i).value;
innerDoc.getElementById(id_rebaja + '_r_' + ida).value=pact;

}

document.getElementById('amount').value='';	
}


function enviaTiendas(){$.ajaxSetup({'async': false});
if(window.debug ==1) {console.log('L419 :enviaTiendas()');};
document.getElementById("timer").style.visibility = "visible";	
var detalle="";
var fini=document.getElementById('fini').value;	
var ffin=document.getElementById('ffin').value;	
var id_rebaja=document.getElementById('idrebaja').value;


var iframe = document.getElementById('FrebAct');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;	
var tisel=innerDoc.getElementById('t_' + id_rebaja).value;

if((id_rebaja)&&(fini)&&(ffin)&&(tisel)){
var iframe = document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
total=innerDoc.getElementById('total').value;	

for (var i = 1; i <= total; i++) {
var id_articulo=innerDoc.getElementById('c_' + i).value;	
var pvp=innerDoc.getElementById('p_' + i).value;	
var precio=innerDoc.getElementById(i).value;
	
if(pvp!=precio){var detalle=detalle + '&arts[' + id_articulo + ']=' + precio;};
}

var url="/ajax/rebToTiend.php?id_rebaja=" + id_rebaja 
+ "&fini=" + fini 
+ "&ffin=" + ffin 
+ "&tisel=" + tisel 
+ detalle;	

$.getJSON(url, function(data) {
$.each(data, function(key, val) {
if(key=='ok'){
alert('Rebajas enviadas correctamente');
document.getElementById('R_nom').value="";
document.getElementById('R_ini').value="";	
document.getElementById('R_fin').value="";
var iframe = document.getElementById('FrebAct');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
total=innerDoc.getElementById('t_' + id_rebaja).value=tisel;


	
}
});
});
}
document.getElementById("timer").style.visibility = "hidden";
}



function creaREB(){$.ajaxSetup({'async': false});if(window.debug ==1) {console.log('L531 :creaREB()');};
if(window.debug ==1) {console.log('window.top.agruNames: '); console.info(window.top.agruNames); };	


var nombre=document.getElementById('R_nom').value;
if(window.top.agruNames.indexOf(nombre) >= 0){alert('Ya existe una agrupación activa con ese nombre.');}else{

if(window.top.agruNames.indexOf(nombre)<0){
window.top.agruNames.push(nombre);
}
var fini=document.getElementById('R_ini').value;fini=fini.replace("dd/mm/aaaa","");	
var ffin=document.getElementById('R_fin').value;ffin=ffin.replace("dd/mm/aaaa","");

if((fini.length==10)&&(ffin.length==10)){
var url="/ajax/rebajasAct.php?action=c&nombre=" + nombre 
+ "&fini=" + fini 
+ "&ffin=" + ffin;

document.getElementById('FrebAct').src=url; 


document.getElementById('R_ini').setAttribute("style", "color:#AAAAAA;");
document.getElementById('R_fin').setAttribute("style", "color:#AAAAAA;");
document.getElementById('R_nom').value="";
document.getElementById('R_ini').value="dd/mm/aaaa";	
document.getElementById('R_fin').value="dd/mm/aaaa";
}else{alert('formato de fecha erroneo');};
	
}}


function ordencodigos(w){$.ajaxSetup({'async': false});
if(window.debug ==1) {console.log('L419 :ordencodigos(w);w='+ w);};



if(w==1){
var id_rebaja=document.getElementById('idrebaja').value;
var cods=window.top.listArts[id_rebaja]; //innerDoc.getElementById('art_' + id_rebaja).value	
}

if(w==2){
var id_rebaja=parent.document.getElementById('idrebaja').value;
var cods=window.top.listArts[id_rebaja]; //document.getElementById('art_' + id_rebaja).value	
}

if(window.debug ==1) {console.log('L567 :START JSON ordencodigos(w);');};
var url= "/ajax/ordenacods.php?codis=" + cods;	
$.get( url, function( data ) {
data=data.replace(/(\r\n|\n|\r)/gm,"")


if(w==1){//innerDoc.getElementById('art_' + id_rebaja).value
		window.top.listArts[id_rebaja]=data;		 	if(window.debug ==1) {console.log('L556 : DesdeF REB_ACT|(art_' + id_rebaja + ') : '+ window.top.listArts[id_rebaja]);};}; //innerDoc.getElementById('art_' + id_rebaja).value
if(w==2){//document.getElementById('art_' + id_rebaja).value
		window.top.listArts[id_rebaja]=data;			if(window.debug ==1) {console.log('L556 : DesdeD REB_ACT|(art_' + id_rebaja + ') : '+ window.top.listArts[id_rebaja]);};}; //document.getElementById('art_' + id_rebaja).value	

});

if(w==1){getRebC_htm2(id_rebaja);};
if(w==2){getRebC_htm(id_rebaja);};

if(window.debug ==1) {console.log('L567 :END JSON ordencodigos(w);');};
	
}

function delAgrupReb(){if(window.debug ==1) {console.log('L587 :delAgrupReb();');};
if(confirm('Esta seguro de borrar la agrupación')){

var id=document.getElementById('idrebaja').value;	
if(id){



var url='/ajax/delREBagrup.php?id=' + id;

$.getJSON(url, function(data) {
$.each(data, function(key, val) {
if(key=='ok'){

var iframe = document.getElementById('FrebAct');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;	
var nom=innerDoc.getElementById('nom_' + id).value;

var inom=window.top.agruNames.indexOf(nom);
window.top.agruNames[inom]='';

var tiendst=innerDoc.getElementById('tdt').value;
if(tiendst){
var ti=tiendst.split(' ');
for (var i = 0; i < ti.length; i++) {document.getElementById('idt_' + ti[i]).setAttribute("style", "background-color:white;");};
}

innerDoc.getElementById(id).remove();
document.getElementById('articulos').src='/ventanas/blank_reb.htm';



}
});
});








	
}else{alert('Seleccione una agrupacion de rebajas para borrarla');};

	
}}






function moveGrid(mv){
var i=$("*:focus").attr("id");


i=Number(i);
if(mv=='up'){i=i-1;};
if(mv=='dw'){i=i+1;};	



if(window.debug ==1) {console.log('NewCamp: ' + i); };	

if(document.getElementById(i)){
$('#'+ i).focus();	
document.getElementById(i).select();
}
	
}

