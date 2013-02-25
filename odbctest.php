

<?php


$conn=odbc_connect('risase','edu','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM Colores";

$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}




while (odbc_fetch_row($rs))
  {
  $idcol=odbc_result($rs,"col_IdColor");
  $color=odbc_result($rs,"col_Color");
  echo "$idcol -> $color <br>";
  
  }

odbc_close($conn);


?>




