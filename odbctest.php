

<?php

$server="SERVER";
$user="edu";
$password="admin";
$database="Test";

$conn=odbc_connect('risase','edu','admin');
$sql="SELECT * FROM colores";
$rs=odbc_exec($conn,$sql);

?>




