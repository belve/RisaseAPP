function dlF(id){
document.getElementById(id).value="";
document.getElementById(id).setAttribute("style", "color:#333333;");
}

function tabF(id){
var fech=document.getElementById(id).value;
if(fech.length==2){fech=fech + '/';};
if(fech.length==5){fech=fech + '/';};
var fech=fech.replace("//","/");
document.getElementById(id).value=fech;	
}
