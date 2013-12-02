$.ajaxSetup({'async': false});


function buscaREF(ref){
if(ref.length>2){	
url = "/ajax/buscaREF.php?ref=" + ref;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
if(key=='html'){document.getElementById('refs').innerHTML=val;}
});
});
}
	
	
}

function selREF(cod){
document.getElementById('cod').value=cod;	
document.getElementById('cod').select();
cargaArticulo(cod);	
}

function cargaArticulo(codbarras){
document.getElementById('foto').src='';	
window.ok=0;
url = "/ajax/modarticulos.php?codbarras=" + codbarras;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

if(key==1){if(document.getElementById('id')){document.getElementById('id').value=val;}}
  
if(key==8){
if(val==0){document.getElementById(key).checked=false;};
if(val==1){document.getElementById(key).checked=true;};	
}else{
if(document.getElementById(key)){document.getElementById(key).value=val;};
}


if((key==1)&&(val!='')){
window.ok=1;

}
	



});
});

if(window.ok==0){alert('Codigo no encontrado');}else{cargafoto(codbarras);	};	
document.getElementById('cod').select();	
}


function cargafoto(id){
document.getElementById('foto').src='http://192.168.1.11/photos/nodisp.jpg';	
url = "/ajax/getimage.php?nodet=1&codbarras=" + id;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

if(key==0){
val=val.replace('c:/D/fotos/','');	
document.getElementById('foto').src='http://192.168.1.11/photos/' + val;};  

if(key>0){
if(document.getElementById('opciones')){	
var op=document.getElementById('opciones').innerHTML;
op=op + val + " ";
document.getElementById('opciones').innerHTML=op;};  

}

});
});	


}



function calcosto(iva){


var costo=document.getElementById('13').value;
var dto1=document.getElementById('6').value
var dto2=document.getElementById('7').value

var neto=(costo - (costo / (100/dto1)) - (costo / (100/dto2))) * iva;
var fran=neto * (1.20);

var neto=Math.round(neto*100)/100
var fran=Math.round(fran*100)/100
document.getElementById('14').value=neto;
document.getElementById('15').value=fran;
}

function modiArt(){

timer(1);

var id=	document.getElementById('1').value;	

var refprov=document.getElementById('9').value;
var stock=document.getElementById('10').value;
var uniminimas=document.getElementById('11').value;
var preciocosto=document.getElementById('13').value;
var precioneto=document.getElementById('14').value;
var preciofran=document.getElementById('15').value;
var temporada=document.getElementById('12').value;
var pvp=document.getElementById('16').value;
var detalles=document.getElementById('18').value;
var comentarios=document.getElementById('19').value;
var stockini=document.getElementById('20').value;

if(document.getElementById('8').checked==true){var congelado=1;}else{var congelado=0;};
	
url = "/ajax/update2.php?tabla=articulos&campos[stock]=" + stock + 
"&campos[refprov]=" + refprov  + 
"&campos[uniminimas]=" + uniminimas  + 
"&campos[preciocosto]=" + preciocosto  +  
"&campos[precioneto]=" + precioneto  +  
"&campos[preciofran]=" + preciofran  +  
"&campos[temporada]=" + temporada  + 
"&campos[pvp]=" + pvp  +  
"&campos[detalles]=" + detalles  +  
"&campos[comentarios]=" + comentarios  +  
"&campos[congelado]=" + congelado  +  
"&campos[stockini]=" + stockini  +  
"&id=" + id;
$.getJSON(url, function(data) {
});	

foc();
timer(0);
}

function foc(){
	
document.getElementById('cod').focus();
document.getElementById('cod').select();
}

