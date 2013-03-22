
$('.example-default-value').each(function() {
    var default_value = this.value;
    $(this).focus(function() {
        if(this.value == default_value) {
            this.value = '';
        }
    });
    $(this).blur(function() {
        if(this.value == '') {
            this.value = default_value;
        }
    });
});


function mainmenu(){
// Oculto los submenus
$(" #nav ul ").css({display: "none"});
// Defino que submenus deben estar visibles cuando se pasa el mouse por encima
$(" #nav li").hover(function(){
    $(this).find('ul:first:hidden').css({visibility: "visible",display: "none"}).slideDown(400);
    },function(){
        $(this).find('ul:first').slideUp(400);
    });
}
$(document).ready(function(){
    mainmenu();
});


function cwin(value){
$("#"+value).remove();
$("#m_"+value).remove();
}



function focusW(value){

	var i=1;
			while (i<25)
			  {
			if(document.getElementById("v_"+i)){
				document.getElementById("v_"+i).style.display = "none";
				document.getElementById("m_v_"+i).setAttribute("class", "minimi_off")  
			}
			  i++;
			}

	document.getElementById(value).style.display = "block";
	document.getElementById("m_"+value).setAttribute("class", "minimi_on");  
}



function owin(value,tit){
			var i=1;
			while (i<25)
			  {
			if(document.getElementById("v_"+i)){
				document.getElementById("v_"+i).style.display = "none";
				document.getElementById("m_v_"+i).setAttribute("class", "minimi_off")  
			}
			  i++;
			}
	
	
	
	
	if(document.getElementById(value)) {
	document.getElementById(value).style.display = "block"; 
	document.getElementById("m_"+value).setAttribute("class", "minimi_on");  	
	}else{
	var html='<div id="' + value +'" class="'+ value  + '"><div class="contenedor gris2_BG shadow"><div class="cabcontenerdor"><div class="tit_contenedor">'+ tit +
	'</div><div class="iconos closeW" onclick="javascript:cwin(\'' +	 value + '\')"></div></div><div class="iframe"><iframe src="/ventanas/'+ value +'.php" width="100%" height="100%" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe></div></div></div>';
	$('#ventanas').append(html);
	
	var minhtml='<div class="minimi_on" id="m_' + value +'" onclick="javascript:focusW(\''+ value +'\')">' + tit + '<div class="iconos closeW"  onclick="javascript:cwin(\'' + value + '\')"></div></div>';
	$('#minimizadas').append(minhtml);
	}
	
}

function timer(w){

if(w==0){document.getElementById("timer").style.visibility = "hidden";};
if(w==1){document.getElementById("timer").style.visibility = "visible";};	
	
}


function example_append() {
    $('#example').append('jajajajajaj');
}

function borra(){
	$("#dd").remove();
}