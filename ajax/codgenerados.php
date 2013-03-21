<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="/js/jquery.zclip.js"></script>






</head>




<body style="background-color: #ffffff;">



<script>
  
function copyIntoClipboard(text) {

    var flashId = 'flashId-HKxmj5';

    /* Replace this with your clipboard.swf location */
    var clipboardSWF = '/ajax/clipboard.swf';

    if(!document.getElementById(flashId)) {
        var div = document.createElement('div');
        div.id = flashId;
        document.body.appendChild(div);
    }
    document.getElementById(flashId).innerHTML = '';
    var content = '<embed src="' + 
        clipboardSWF +
        '" FlashVars="clipboard=' + encodeURIComponent(text) +
        '" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" allowfullscreen="false" allowscriptaccess="always" ></embed>';
    document.getElementById(flashId).innerHTML = content;
}



function copiaporta(element){
	var doc = document;
    var text = doc.getElementById(element);    

    if (doc.body.createTextRange) { // ms
        var range = doc.body.createTextRange();
        range.moveToElementText(text);
        range.select();
    } else if (window.getSelection) { // moz, opera, webkit
        var selection = window.getSelection();            
        var range = doc.createRange();
        range.selectNodeContents(text);
        selection.removeAllRanges();
        selection.addRange(range);
    }
}

</script>



 

<div class="codbarras">
<ul id="codbarras">
	
	
</ul>
</div>




</body>
</html>



