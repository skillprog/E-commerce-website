<?php
/**
 * Created by PhpStorm.
 * User: beckas
 * Date: 2017-11-13
 * Time: 18:32
 */
session_start();
include 'connect.php';

session_destroy();

echo "<script>window.open('index.php','_self')</script>";
?>