<?php


#$conn=odbc_connect("risasenew","remoto","azul88");
#if (!$conn)
#{exit("Connection Failed: " . $conn);}
#$sql="SELECT * FROM Articulos where art_idArticulo <= 50 ;";

#$rs=odbc_exec($conn,$sql);
#if (!$rs)
#  {exit("Error in SQL");}




#while (odbc_fetch_row($rs)){
#foreach($camp as $nkey => $nomcampo){
#$valores[trim(odbc_result($rs,$Nid))][$nkey]=trim(utf8_encode(odbc_result($rs,$nomcampo)));
#}}

#odbc_close($conn);


 include('../adodb5/adodb.inc.php');
$db =& ADONewConnection('odbc_mssql');
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risase;";
$db->Connect($dsn,'remoto','azul88');

$rs = $db->Execute('SELECT * FROM Articulos where art_idArticulo <= 50;');

         print "<pre>";

         print_r($rs->GetRows());

         print "</pre>";

?>

