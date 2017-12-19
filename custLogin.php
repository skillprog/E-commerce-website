<?php
/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-12-03
 * Time: 00:10
 */

session_start();

include ("db/dbconnection.php");

?>


<div style="width: 700px; height: 650px; margin-left: 25%; margin-right: 25%; border: solid red 2px;">


    <h2 style="text-align: center" >Logga in eller registrera dig för att slutföra köpet!</h2>
    <hr>
    <form method="post" action="">

        <table style="margin-top: 30px; " width="100%" align="center" bgcolor="#dcdcdc" >



            <tr>
                <td style="text-align: center">E-post</td>
                <td style="text-align: center"><input type="text" name="email" placeholder="ange e-post" required/></td>
            </tr>

            <tr>
                <td style="text-align: center">Lösenord</td>
                <td style="text-align: center"><input type="password" name="pass" placeholder="ange lösenord" required/></td>
            </tr>

            <tr>
                <td style="text-align: center"><input type="submit" name="login" value="login"/></td>
            </tr>
            <tr>
                <td><br><br></td>
            </tr>

            <tr>
                <td style="text-align: center"><a href="checkout.php?forgotPass">Glömt lösenordet?</a> </td>
            </tr>

        </table>
        <br>

        <div style="width: 100%; height:70px; background-color: #dcdcdc; ">
        <h2 style="float: left;"><a href="custRegister.php" style="text-decoration: none">Ny kund? Registrera dig här</a></h2>
        </div>

    </form>

    <?php

    if(isset($_POST['login'])){

        $custEmail = $_POST['email'];
        $custPass = $_POST['pass'];

        $selectCust = "select * from customers WHERE customerPass='$custPass' AND customerEmail='$custEmail'";

        $runCust = mysqli_query($dbcon,$selectCust);

        $checkCust = mysqli_num_rows($runCust);

        if($checkCust==0){

            echo "<script>alert('Lösenordet eller E-post adressen är felaktig, vänligen försök igen!')</script>";
            exit();
        }

        $ip = getIp();

        $selectCart = "select * from cart where prodADD='$ip'";

        $runCart = mysqli_query($dbcon,$selectCart);

        $checkCart = mysqli_num_rows($runCart);

        if ($checkCust>0 and $checkCart==0){
            $_SESSION['customerEmail']=$custEmail;
            echo "<script>alert('Inloggning lyckades!')</script>";
            echo "<script>window.open('customer/custProfile.php','_self')</script>";
        }else{

            $_SESSION['customerEmail']=$custEmail;
            echo "<script>alert('Inloggning lyckades!')</script>";
            echo "<script>window.open('checkout.php','_self')</script>";

        }
    }



    ?>


</div>