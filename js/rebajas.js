function selReb(id,todos){
parent.document.getElementById("timer").style.visibility = "visible";	
var art=todos.split(',');
for (var i = 0; i < art.length; i++) {
if(art[i]!=''){	document.getElementById(art[i]).setAttribute("style", "background-color:white;");};
}	
document.getElementById(id).setAttribute("style", "background-color:#8DC29E;");
parent.document.getElementById('idrebaja').value=id;

url = "/ajax/addartREB.php?id_rebaja=" + id;
parent.document.getElementById('articulos').src=url;

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

}


function cajtie(idt){
var sels=document.getElementById('tisel').value;var estaba=0;var newsel="";
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
document.getElementById('tisel').value=newsel;

	

}


function chPrice(h){

var amount=document.getElementById('amount').value;
var amount=Number(amount);

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
}

	
}


function enviaTiendas(){var detalle="";
var fini=document.getElementById('fini').value;	
var ffin=document.getElementById('ffin').value;	
var tisel=document.getElementById('tisel').value;
var id_rebaja=document.getElementById('idrebaja').value;

if((id_rebaja)&&(fini)&&(ffin)&&(tisel)){
var iframe = document.getElementById('articulos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
total=innerDoc.getElementById('total').value;	

for (var i = 1; i <= total; i++) {
var id_articulo=innerDoc.getElementById('c_' + i).value;	
var precio=innerDoc.getElementById(i).value;	

var detalle=detalle + '&arts[' + id_articulo + ']=' + precio;
}

var url="/ajax/rebToTiend.php?id_rebaja=" + id_rebaja 
+ "&fini=" + fini 
+ "&ffin=" + ffin 
+ "&tisel=" + tisel 
+ detalle;	

$.getJSON(url, function(data) {
$.each(data, function(key, val) {

});
});
}

}



function creaREB(){
var nombre=document.getElementById('R_nom').value;
var fini=document.getElementById('R_ini').value;	
var ffin=document.getElementById('R_fin').value;

var url="/ajax/rebajasAct.php?action=c&nombre=" + nombre 
+ "&fini=" + fini 
+ "&ffin=" + ffin;

document.getElementById('FrebAct').src=url; 
	
}
