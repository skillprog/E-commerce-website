<?php
/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-12-14
 * Time: 05:08
 */

include("admindbcon.php");

    global $dbcon;

    if(isset($_GET['adminDelete'])){

        $delID = $_GET['adminDelete'];

        $deleteProds = "delete from products where productID='$delID'";
        $runDelete = mysqli_query($dbcon, $deleteProds);

        if($runDelete){

            echo "<script>alert('Produkten har tagits bort!')</script>";
            echo "<script>window.open('index.php?adminView','_self' )</script>";
        }
    }


?>