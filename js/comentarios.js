function listaArticulosCom(h){
timer(1);

var prov=document.getElementById('2').value
var grup=document.getElementById('3').value
var subg=document.getElementById('4').value
var colo=document.getElementById('5').value
var codi=document.getElementById('6').value
var pvp=document.getElementById('7').value
var desd=document.getElementById('8').value
var hast=document.getElementById('9').value
var temp=document.getElementById('10').value
var options=document.getElementById('options').value;
var text=document.getElementById('text').value;
	
url = "/ajax/listarticulosComen.php?id_proveedor=" + prov
 + "&id_grupo=" + grup
 + "&id_subgrupo=" + subg
 + "&id_color=" + colo
 + "&codigo=" + codi
 + "&pvp=" + pvp
 + "&desde=" + desd
 + "&hasta=" + hast
 + "&temporada=" + temp
 + "&h=" + h
 + "&optionsdo=" + options
 + "&text=" + text;
  
 document.getElementById('articulos').src=url;	
	
}
