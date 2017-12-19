<?php
//denna behöver inte användas.
$message = '';

$db = new mysqli('localhost', 'admin', 'admin', 'webshopdb');


if($db->connect_error){
	
	$message = $db->connect_error;
}

echo $message;

?>