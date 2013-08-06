<?php


$conn=odbc_connect('mdb','local','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM Articulos;";


$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}



$count=1;
while (odbc_fetch_row($rs))
  {$count++;

	$id=trim(utf8_encode(odbc_result($rs,'art_idArticulo')));
	echo $id;
  }

odbc_close($conn);


?>