<?php
/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-12-14
 * Time: 05:08
 */

include("admindbcon.php");

global $dbcon;

if(isset($_GET['adminDeleteCust'])){

    $delID = $_GET['adminDeleteCust'];

    $deleteCust = "delete from customers where customerID='$delID'";
    $runDelete = mysqli_query($dbcon, $deleteCust);

    if($runDelete){

        echo "<script>alert('Kunden har tagits bort!')</script>";
        echo "<script>window.open('index.php?adminViewCust','_self' )</script>";
    }
}


?>