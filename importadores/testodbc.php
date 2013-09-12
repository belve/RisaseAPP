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

$Ntab='Articulos';

$Nid='art_idArticulo';

$camp[1]='art_idProveedor';
$camp[2]='art_idSubgrupo';
$camp[3]='art_idColor';
$camp[4]='art_Codigo';
$camp[5]='art_RefProv';
$camp[6]='art_Foto';
$camp[7]='art_UniStock';
$camp[8]='art_UniMinimas';
$camp[9]='art_CodBarras';
$camp[10]='art_Temporada';
$camp[11]='art_PrecioCosto';
$camp[12]='art_PrecioNeto';
$camp[13]='art_PrecioFran';
$camp[14]='art_PVP';
$camp[15]='art_Congelado';
$camp[16]='art_Stockini';


include('../adodb5/adodb.inc.php'); $driv="odbc_mssql";
$db =& ADONewConnection($driv);
$dsn = "Driver={SQL Server};Server=SERVER;Database=Risase;";
$db->Connect($dsn,'remoto','azul88');
$db->debug = false;
$rs = $db->Execute('SELECT * FROM Articulos where art_idArticulo <= 50;');

while ($row = $rs->GetRows()){
	
print_r($row);	
foreach($camp as $nkey => $nomcampo){
	 #$valores[trim($row[0])][$nkey]=trim(utf8_encode($row[$nkey]));
}

}      

print_r($valores);
?>

