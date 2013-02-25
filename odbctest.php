

<?php

// El servidor con el formato: <computer>\<instance name> o 
// <server>,<port> cuando se use un número de puerto diferente del de defecto

$server = 'SERVER';

// Connect to MSSQL
$link = mssql_connect($server, 'edu', 'admin');

if (!$link) {
    die('Algo fue mal mientras se conectava a MSSQL');
}else{
	echo "yesss";
}


?>




