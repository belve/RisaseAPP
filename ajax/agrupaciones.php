<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/pedidos.js"></script>

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
body { background-color: white;}
</style>


<input type='hidden' value='' id='agrupSel'>

<div id="agrupaciones"> </div>


</body></html>