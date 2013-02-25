

<?php


$conn=odbc_connect('risase','edu','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM colores";

$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}


print_r(odbc_fetch_row($rs));

odbc_close($conn);


?>




