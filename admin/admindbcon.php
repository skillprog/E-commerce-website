<?php
/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-11-13
 * Time: 02:00
 */

$message = '';

$dbcon = new mysqli("localhost", "admin", "admin", "webshopdb");


if($dbcon->connect_error){

    $message = $dbcon->connect_error;
}

echo $message;


?>