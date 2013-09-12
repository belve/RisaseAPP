<?php


#$conn=odbc_connect("risasenew","remoto","azul88");
#if (!$conn)
#{exit("Connection Failed: " . $conn);}
$sql="SELECT * FROM Articulos where art_idArticulo <= 50 ;";
#$rs=odbc_exec($conn,$sql);
#if (!$rs)
#  {exit("Error in SQL");}




#while (odbc_fetch_row($rs)){
#foreach($camp as $nkey => $nomcampo){
#$valores[trim(odbc_result($rs,$Nid))][$nkey]=trim(utf8_encode(odbc_result($rs,$nomcampo)));
#}}

#odbc_close($conn);



$myServer = "SERVER";
$myUser = "remoto";
$myPass = "azul88";
$myDB = "Risase"; 

//connection to the database
$dbhandle = mssql_connect($myServer, $myUser, $myPass)
  or die("Couldn't connect to SQL Server on $myServer"); 

//select a database to work with
$selected = mssql_select_db($myDB, $dbhandle)
  or die("Couldn't open database $myDB"); 

//declare the SQL statement that will query the database
$query = $sql;

//execute the SQL query and return records
$result = mssql_query($query);

$numRows = mssql_num_rows($result); 
echo "<h1>" . $numRows . " Row" . ($numRows == 1 ? "" : "s") . " Returned </h1>"; 

//display the results 
while($row = mssql_fetch_array($result))
{
  echo "<li>" . $row["id"] . $row["name"] . $row["year"] . "</li>";
}
//close the connection
mssql_close($dbhandle);
?>

