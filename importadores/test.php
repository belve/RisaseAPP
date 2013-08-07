<?php



foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};


$conn=odbc_connect($dsn,$user,$pass);

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM Pedidos where pti_FechaPedido >= '01/01/$ini';";


$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}



$count=1;
while (odbc_fetch_row($rs))
{

echo $rs['pti_FechaPedido'] . "<br>";

}




odbc_close($conn);



?>