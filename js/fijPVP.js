window.debug =1;

function addArticulo(codigo){


var prov=document.getElementById(2).value
var grup=document.getElementById(3).value
var subg=document.getElementById(4).value
var colo=document.getElementById(5).value
var codi=document.getElementById(6).value
var pvp=document.getElementById(7).value
var desd=document.getElementById(8).value
var hast=document.getElementById(9).value
var temp=document.getElementById(10).value;

var fijCHK=window.top.solofij;

document.getElementById(2).value="";
document.getElementById(3).value="";
document.getElementById(4).value="";
document.getElementById(5).value="";
document.getElementById(6).value="";
document.getElementById(7).value="";
document.getElementById(8).value="";
document.getElementById(9).value="";
document.getElementById(10).value="";
	


	
url = "/ajax/addARTfPVP.php?id_proveedor=" + prov
 + "&id_grupo=" + grup
 + "&id_subgrupo=" + subg
 + "&id_color=" + colo
 + "&codigo=" + codi
 + "&pvp=" + pvp
 + "&desde=" + desd
 + "&hasta=" + hast
 + "&fijCHK=" + fijCHK
 + "&temporada=" + temp

 + '&listador=1'; 


var yalist=window.top.listArts.toString();
url=url  + "&yalistados=" + yalist;


getDATA(url);

}






function getDATA(url){timer(1);
$.ajaxSetup({'async': false});	



//var iframe = document.getElementById('repartos');
//var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
window.top.T_listArts=new Array();
window.top.T_Codbars=new Array();
window.top.T_pvps=new Array();

	var tiendas=window.top.tiet;
	for (var a = 0; a < tiendas.length; a++) {var tiee='T_t_' + tiendas[a];
	window.top[tiee]=new Array();	
	}

	


$.getJSON(url, function(data) {
$.each(data, function(key, val) {
	
if(key!=key.replace('i_','')){
window.top.T_listArts.push(val);		
}

if(key!=key.replace('c_','')){
window.top.T_Codbars.push(val);		
}

if(key!=key.replace('p_','')){
window.top.T_pvps.push(val);		
}


if(key!=key.replace('t_','')){
var keys=key.split('|');var tie='T_' + keys[0];	var tieL=keys[0];
var a=window.top.listArts.indexOf(keys[1]*1);
if(!window.top[tieL][a]){ window.top[tie].push(val); }else{ window.top[tie].push(window.top[tieL][a]); };         
}




});
});



window.top.listArts=window.top.T_listArts;
window.top.Codbars=window.top.T_Codbars;
window.top.pvps=window.top.T_pvps;
 
 
	for (var a = 0; a < tiendas.length; a++) {var tien='t_' + tiendas[a]; var tiee='T_t_' + tiendas[a];
	window.top[tien]=window.top[tiee];	
	}


if(window.debug ==1) {console.log('window.top.listArts: '); console.info(window.top.listArts); };
if(window.debug ==1) {console.log('window.top.t_17: '); console.info(window.top.t_17); };

loadGRID();
timer(0);
}

function loadGRID(){timer(1);
var htm=''; var htm2='';	
var arts=window.top.listArts;

window.top.filas=new Array();

for (var i = 0; i < arts.length; i++) {var htm2='';
htm2=htm2 + '<tr id="' + i + '">';
htm2=htm2 + '<td class="tdA"><input type="text" readonly value="' + window.top.Codbars[i] + '" class="camp_REP_art" style="width: 160px;"></td>'
htm2=htm2 + '<td class="tdP"><input type="text" readonly value="' + window.top.pvps[i] + '" class="camp_REP_alm"></td>'

	var tiendas=window.top.tiet;var sum=0;
	for (var a = 0; a < tiendas.length; a++) {
	htm2=htm2 + '<td class="tdT">';	
	
	var tie='t_' + tiendas[a];
	var impo=window.top[tie][i];
	impo=Number(impo);
	sum=sum+impo;
	impo=impo.toFixed(2);
	if(impo==0){impo='';};
	htm2=htm2 + '<input type="text" onfocus="this.select();" value="'+ impo + '" class="fpvpvt" id="' + i + '_' + tiendas[a] + '" onchange="chfij(this.id,this.value);">';
	htm2=htm2 + '</td>';	
	}









htm2=htm2 + '</tr>';

var todos=window.top.solofij;
if(sum>0){
htm=htm+htm2; window.top.filas.push(i);
}else if(todos==0){
htm=htm+htm2; window.top.filas.push(i);		
}


}




var iframe = document.getElementById('fijosPVP');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('tfPVP').innerHTML=htm;	
timer(0);
}




function moveGrid(mv){
var i=$("*:focus").attr("id");
var vals=i.split('_');

var F=vals[0];
var C=vals[1];

F=F*1;
C=C*1;




if(mv=='up'){
var f=window.top.filas.indexOf(F); f=f-1;	
var F=window.top.filas[f];	
};	

if(mv=='dw'){
var f=window.top.filas.indexOf(F);f=f+1;	
var F=window.top.filas[f];	
};	

if(mv=='lf'){
var c=window.top.tiet.indexOf(C);c=c-1;	
var C=window.top.tiet[c];
};	

if(mv=='ri'){
var c=window.top.tiet.indexOf(C);c=c+1;	
var C=window.top.tiet[c];
};	
	
var i=F + "_" + C;



if(window.debug ==1) {console.log('NewCamp: ' + i); };	

if(document.getElementById(i)){
setTimeout("$('#" + i + "').focus();",10);	
document.getElementById(i).select();
}
	
}


function solofij(){
if(window.top.solofij==0){window.top.solofij=1;}else{window.top.solofij=0;}

if(window.top.solofij==0){
document.getElementById('divfij').setAttribute("style", "background-color:trasparent;;");	
document.getElementById('fijCHK').checked=0;
}

if(window.top.solofij==1){
document.getElementById('divfij').setAttribute("style", "background-color:#8DC29E;");	
document.getElementById('fijCHK').checked=1;
}


loadGRID();	
}




function chfij(campo,pvp){
pvp=pvp.replace(',','.');

var camps=campo.split('_');
var ar=camps[0];
var ti='t_' + camps[1];

pvp=Number(pvp);	
pvp =pvp.toFixed(2);



window.top[ti][ar]=pvp;	
if(pvp==0){pvp='';};
document.getElementById(campo).value=pvp;	
}







function limpiarGRID(){
window.top.listArts =new Array();
window.top.Codbars =new Array();
window.top.pvps	=new Array();
	
loadGRID();		
}


function envFIJ(){
$.ajaxSetup({'async': false});
var arts=window.top.listArts;

var url="";
for (var i = 0; i < arts.length; i++) {

var id_a=arts[i];
	var tiendas=window.top.tiet;var sum=0;
	for (var a = 0; a < tiendas.length; a++) {
	
var id_t=tiendas[a];
	
	var tie='t_' + tiendas[a];
	var impo=window.top[tie][i];
	impo=Number(impo);
var pvp=impo.toFixed(2);

url=url + '&fijos[' + id_a + '][' + id_t + ']=' +pvp;
	
	}
	

}

url=url.substr(1);	
ComtoDB(url);

}


function ComtoDB(url){$.ajaxSetup({'async': false});
timer(1);
$.post("/ajax/envFIJ.php",url,function(data,status){
alert("Datos enviados a tiendas");
 });
timer(0);	
}





