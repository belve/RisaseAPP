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


function cColoresC(){
var actual=	document.getElementById('ccolor').value;
cargaColores(actual);	
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

function cargaColoresS(){
var actual=	document.getElementById('color_id').value;
cargaColores(actual);
}

function saveColor(){
var id=	document.getElementById('color_hid').value;	
var name=document.getElementById('color_name').value;	
url = "/ajax/update-bd.php?tabla=colores&id=" + id + "&name=" + name;
$.getJSON(url, function(data) {
});
}








function cargaGrupos(pointer){
url = "/ajax/basics-bd.php?tabla=grupos&pointer=" + pointer;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
   document.getElementById('grupos_hid').value=key;
   document.getElementById('grupos_id').value=key;
   document.getElementById('grupos_name').value=val;
});
});
}

function cargaGruposMENOS(){
var actual=	document.getElementById('grupos_hid').value;
actual--;
cargaGrupos(actual);
}

function cargaGruposMAS(){
var actual=	document.getElementById('grupos_hid').value;
actual++;
cargaGrupos(actual);
}


function cargaGruposINI(){
cargaGrupos(0);
}

function cargaGruposFIN(){
cargaGrupos('-1');
}

function cargaGruposS(){
var actual=	document.getElementById('grupos_id').value;
cargaGrupos(actual);
}

function saveGrupo(){
var id=	document.getElementById('grupos_hid').value;	
var name=document.getElementById('grupos_name').value;	
url = "/ajax/update-bd.php?tabla=grupos&id=" + id + "&name=" + name;
$.getJSON(url, function(data) {
});
}



function LoadsubG(){$.ajaxSetup({'async': false});


window.top.idsubg=new Array;
window.top.eqsubg=new Array;
window.top.subNom=new Array;

url = "/ajax/LoadSubG.php?";
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var datos=val.split('|');
window.top.idsubg.push(Number(datos[0]));
window.top.eqsubg.push(datos[1]);
window.top.subNom.push(datos[2]);

});
});

console.info(window.top.idsubg);
	
}

function createSubGrupo(){$.ajaxSetup({'async': false});

var g=document.getElementById('nG').value;
var sg=document.getElementById('nSG').value;	
var nombre=document.getElementById('nName').value;
nombre=nombre.replace(/^\s+/g,'').replace(/\s+$/g,'');

if((g)&&(sg)&&(nombre)){

url = "/ajax/createSubgrupo.php?g=" + g + "&sg=" + sg + "&nombre=" + nombre;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
   if(key == 'lastid'){	window.top.lidd=Number(val);}
   if(key == 'error'){alert(val);};
});
});


LoadsubG();
var lid=Number(window.top.lidd);
var pointer=window.top.idsubg.indexOf(lid);
cargaSubGrupos(pointer);


document.getElementById('nG').value="";
document.getElementById('nSG').value="";	
document.getElementById('nName').value="";
document.getElementById('GforCreate').value="";
	
}}



function cSubGru(idg){
var cod=idg + "1";	
var newi=window.top.eqsubg.indexOf(cod);

console.log('cod:' + cod); 
console.log('newi:' + newi); 


cargaSubGrupos(newi);
}

function CreaSubg(id){
var id=Number(id);

var fin=(window.top.eqsubg.length)-1;
console.log('fin:'+fin);
var ulGD=window.top.eqsubg[fin]; var ulG=ulGD.substr(0,1); var ulSG=ulGD.substr(1,1);
ulG=Number(ulG);
ulSG=Number(ulSG);

if(id==ulG){
newi=ulSG+1;	
}else{
	
var ulti=Number(id+1) + "1"	;

var newi=window.top.eqsubg.indexOf(ulti);
var lp=Number(newi-1);
var last=window.top.eqsubg[lp];

newi=Number(last.substr(1,1));
newi=newi+1;
}

console.log('id:'+id);
console.log('newi:'+newi);
console.log('lp:'+lp);



if(newi<10){	
document.getElementById('nG').value=id;
document.getElementById('nSG').value=newi;	
}else{
alert('No hay codigos disponibles');
document.getElementById('nG').value='';
document.getElementById('nSG').value='';
document.getElementById('GforCreate').value='';	

}
}

function cargaSubGrupos(pointer){$.ajaxSetup({'async': false});

var actual=	window.top.pointer;
var fin=(window.top.idsubg.length)-1;

if (pointer == 'menos')		{actual=(actual*1)-1;}
else if (pointer == 'mas')	{actual=(actual*1)+1;}
else if (pointer == 'fin')	{actual=fin;}
else						{actual=pointer;}

if(actual<0){actual=0;}; if (actual > fin){actual=fin;};

document.getElementById('3').value=window.top.subNom[actual];
var d=window.top.eqsubg[actual];
var g=d.substr(0,1); var sg=d.substr(1,1);

document.getElementById('1').value=g;
document.getElementById('2').value=g;
document.getElementById('4').value=sg;

window.top.pointer=actual;

}







function cargaSubGruposS2(){
var actual=	document.getElementById('1').value;
cargaSubGrupos(actual);
}



function saveSubGrupo(){$.ajaxSetup({'async': false});
var pointer=window.top.pointer;
console.log('pointer:' + pointer);
var id=	window.top.idsubg[pointer];	
var nombre=document.getElementById('3').value;

	
url = "/ajax/update2.php?tabla=subgrupos&campos[nombre]=" + nombre  + "&id=" + id;
$.getJSON(url, function(data) {
	
});
LoadsubG();
}










function createproveedores(){
url = "/ajax/createrecord.php?tabla=proveedores";
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
   if(key == 'lastid'){cargaproveedores2(val);};
});
});
	
}

function cargaproveedores(pointer){
var actual=	document.getElementById('1_hid').value;

if (pointer == 'menos'){pointer=(actual*1)-1;};
if (pointer == 'mas'){pointer=(actual*1)+1;};

url = "/ajax/proveedores.php?pointer=" + pointer;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
  
  if(key == 1){
  	document.getElementById('1_hid').value=val;
   	document.getElementById('1').value=val;
   	document.getElementById('ccolor').value=val;
   	}
   if(key == 2){document.getElementById('2').value=val;};
   if(key == 3){document.getElementById('3').value=val;};
   if(key == 4){document.getElementById('4').value=val;};
   if(key == 5){document.getElementById('5').value=val;};
   if(key == 6){document.getElementById('6').value=val;};
   if(key == 7){document.getElementById('7').value=val;};
   if(key == 8){document.getElementById('8').value=val;};
   if(key == 9){document.getElementById('9').value=val;};
   if(key == 10){document.getElementById('10').value=val;};
   if(key == 11){document.getElementById('11').value=val;};
   if(key == 12){document.getElementById('12').value=val;};
   
  	
 
});
});
}


function cargaproveedores2(pointer){
var actual=	document.getElementById('1_hid').value;

if (pointer == 'menos'){pointer=(actual*1)-1;};
if (pointer == 'mas'){pointer=(actual*1)+1;};

url = "/ajax/proveedores.php?noborro=1&pointer=" + pointer;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
  
  if(key == 1){
  	document.getElementById('1_hid').value=val;
   	document.getElementById('1').value=val;
   	}
   if(key == 2){document.getElementById('2').value=val;};
   if(key == 3){document.getElementById('3').value=val;};
   if(key == 4){document.getElementById('4').value=val;};
   if(key == 5){document.getElementById('5').value=val;};
   if(key == 6){document.getElementById('6').value=val;};
   if(key == 7){document.getElementById('7').value=val;};
   if(key == 8){document.getElementById('8').value=val;};
   if(key == 9){document.getElementById('9').value=val;};
   if(key == 10){document.getElementById('10').value=val;};
   if(key == 11){document.getElementById('11').value=val;};
   if(key == 12){document.getElementById('12').value=val;};
   
  	
 
});
});
}


function cargaproveedoresS(){
var actual=	document.getElementById('1').value;
cargaproveedores(actual);
}



function saveproveedores(){
var id=	document.getElementById('1_hid').value;	
var nombre=document.getElementById('2').value;
var cif=document.getElementById('3').value;
var direccion=document.getElementById('4').value;
var cp=document.getElementById('5').value;
var poblacion=document.getElementById('6').value;
var provincia=document.getElementById('7').value;
var contacto=document.getElementById('8').value;
var telefono=document.getElementById('9').value;
var fax=document.getElementById('10').value;
var email=document.getElementById('11').value;
var nomcorto=document.getElementById('12').value;

if(nomcorto.length>6){
	
alert('La abreviatura del proveedor debe tener un máximo de 6 caracteres');	
}else{
	
url = "/ajax/update2.php?tabla=proveedores"
+ "&campos[nombre]=" + nombre  
+ "&campos[cif]=" + cif  
+ "&campos[direccion]=" + direccion  
+ "&campos[cp]=" + cp  
+ "&campos[poblacion]=" + poblacion  
+ "&campos[provincia]=" + provincia  
+ "&campos[contacto]=" + contacto  
+ "&campos[telefono]=" + telefono  
+ "&campos[fax]=" + fax  
+ "&campos[email]=" + email  
+ "&campos[nomcorto]=" + nomcorto  

+  "&id=" + id;
$.getJSON(url, function(data) {
});


}

}






