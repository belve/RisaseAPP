function getCookieT(c_name)
{
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

function setCookieT(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString()) + "; path=/";
document.cookie=c_name + "=" + c_value;
}


function getArtfrBD(id){$.ajaxSetup({'async': false});

var ocultos="";
var arts=document.getElementById('art_' + id).value;
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


document.getElementById('art_' + id).value=arts;
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
var id=	document.getElementById('idrebaja').value;
var ocultos="";
var iframe = document.getElementById('FrebAct');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var arts=innerDoc.getElementById('art_' + id).value;


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
innerDoc.getElementById('art_' + id).value=arts;

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
getRebC_htm2(id);
}






function getRebC_htm2(id){$.ajaxSetup({'async': false});
var iframe = document.getElementById('FrebAct');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var arts=innerDoc.getElementById('art_' + id).value;

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

document.getElementById("timer").style.visibility = "hidden";	
}




function refrescaSel(){
	
var total=document.getElementById('total').value;
var select=document.getElementById('select').value;	
	
for (var i = 1; i < total; i++){
	document.getElementById('TR_' + i).setAttribute("style", "background-color:white;");	
}
var sels=select.split(' ');

for (var i = 0; i < sels.length; i++){
	if( document.getElementById('TR_' + sels[i]) ){
		document.getElementById('TR_' + sels[i]).setAttribute("style", "background-color:#8DC29E;");
}}	
}


function selFil(fil){
var id=fil.replace('F_','');	
var select=document.getElementById('select').value;
var noselect=select.replace(id + " ",'');
if(select==noselect){
	select=select + id + " ";
	document.getElementById('select').value=select;
	}else{
	document.getElementById('select').value=noselect;	
	}



refrescaSel();


}

function seltodsR(){
var iframe = document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;	
	
var total=innerDoc.getElementById('total').value;
var select='';		
for (var i = 1; i <= total; i++){
select=select + i + " ";
}	
innerDoc.getElementById('select').value=select;	

refrescaSelTOP();	
}


function borraselR(){
var id=document.getElementById('idrebaja').value
var iframe = document.getElementById('FrebAct');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;	
var arts=innerDoc.getElementById('art_' + id).value;

var iframe = document.getElementById('articulos');
var innerDoc2 = iframe.contentDocument || iframe.contentWindow.document;	
var select=innerDoc2.getElementById('select').value;	

var sels=select.split(' ');
var count=0;

for (var i = 0; i < sels.length; i++){
if(innerDoc2.getElementById('c_' + sels[i])){
	
count++;
	
var cod=innerDoc2.getElementById('c_' + sels[i]).value;
arts=arts.replace(' ' + cod,'');
innerDoc2.getElementById("oc_" +  cod).remove();

}}


innerDoc.getElementById('art_' + id).value=arts;
getRebC_htm2(id);	
}

function refrescaSelTOP(){
var iframe = document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;		
var total=innerDoc.getElementById('total').value;
var select=innerDoc.getElementById('select').value;	
	
for (var i = 1; i < total; i++){
	innerDoc.getElementById('TR_' + i).setAttribute("style", "background-color:white;");	
}
var sels=select.split(' ');

for (var i = 0; i < sels.length; i++){
	if( innerDoc.getElementById('TR_' + sels[i]) ){
		innerDoc.getElementById('TR_' + sels[i]).setAttribute("style", "background-color:#8DC29E;");
}}	
}




function getRebC_htm(id){$.ajaxSetup({'async': false});
var arts=document.getElementById('art_' + id).value;
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
parent.document.getElementById("timer").style.visibility = "hidden";

}


function selReb(id,todos){
	
	
var iframe = parent.document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;	
innerDoc.getElementById('select').value='';	
	
	
parent.document.getElementById("timer").style.visibility = "visible";	
var art=todos.split(',');
for (var i = 0; i < art.length; i++) {
if(art[i]!=''){	document.getElementById(art[i]).setAttribute("style", "background-color:white;");};
}	
document.getElementById(id).setAttribute("style", "background-color:#8DC29E;");
parent.document.getElementById('idrebaja').value=id;


var arts=document.getElementById('art_' + id).value;
if(!arts){getArtfrBD(id);}
getRebC_htm(id);




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


function cajtie(idt){
	
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
var precio=	document.getElementById(i).value;
var precio=Number(precio);
var precio = precio.toFixed(2);
var id_rebaja=parent.document.getElementById('idrebaja').value;	
var ida=document.getElementById('c_' + i).value;
document.getElementById(id_rebaja + '_r_' + ida).value=precio;
document.getElementById(i).value=precio;
}


function chPrice(h){

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

	
}


function enviaTiendas(){$.ajaxSetup({'async': false});
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



function creaREB(){$.ajaxSetup({'async': false});
var nombre=document.getElementById('R_nom').value;
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
	
}
