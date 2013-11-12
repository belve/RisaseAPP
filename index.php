<?php
session_cache_expire(0);
session_start();
if(!array_key_exists('ussid', $_SESSION)){
require_once("notlogged.php");	
}else{
require_once("logged.php");

}






?>




