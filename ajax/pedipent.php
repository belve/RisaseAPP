<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>


<script type="text/javascript" src="/js/pedidos.js"></script>
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />

</head>

<body>
	
<script>

$(window).keydown(function(evt) {
  if (evt.which == 17) { // ctrl
  top.document.getElementById('crtl').value=1;
  }
}).keyup(function(evt) {
  if (evt.which == 17) { // ctrl
  top.document.getElementById('crtl').value=0;
  }
});

</script>	
	

<style>
body { background-color: white;  margin:0px;padding: 0px;}
</style>

<input type="hidden" id='ini' value='0'><input type="hidden" id='fin' value='0'>
<input type="hidden" id='artselected' value=''>
<div id="pedipent">
	
</div>


</body></html>