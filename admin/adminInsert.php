<?php
/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-11-12
 * Time: 22:20
 */

include("admindbcon.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datanördarna</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../bootstrap/css/bootstrap-responsive.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../bootstrap/js/bootstrap.js">
</head>

<body>

<!-- start page-wrapper -->
<div class=wrapper>

    <!-- navigation menu -->

    <!-- end navigation menu -->

    <div id=content>


        <form action="adminInsert.php" method="post" enctype="multipart/form-data">

            <table align="center" width="50%">

                <tr align="center">
                    <td><h2>Skapa ny artikel</h2></td>
                </tr>


                <tr align="center">
                    <td>Titel för produkt:</td>
                    <td><input type="text" name="productTitle" required/></td>
                </tr>

                <tr align="center">
                    <td>Bild för produkt:</td>
                    <td><input type="file" name="productImg"/></td>
                </tr>

                <tr align="center">
                    <td>Pris för produkt:</td>
                    <td><input type="text" name="productPrice" required/></td>
                </tr>

                <tr align="center">
                    <td>Beskriving av produkt:</td>
                    <td><textarea name="productDesc" cols="10" rows="5"></textarea></td>
                </tr>

                <tr align="center">
                    <td>Antal av produkt</td>
                    <td><input type="number" name="productQTY" min="1" max="10" required> </td>
                </tr>

               <tr align="center">
                   <td><input type="submit" name="insertPost" value="Skicka"/></td>
               </tr>


            </table>

        </form>


    </div> <!-- end content -->

</div> <!-- end wrapper -->


</body>

</html>

<?php

    //get text/data from fields and send through POST.
    if(isset($_POST['insertPost'])){

        $productTitle = $_POST['productTitle'];

        $productImg = $_FILES['productImg']['name'];
        $productImg_tmp = $_FILES['productImg']['tmp_name'];

        move_uploaded_file($productImg_tmp,"prod_img/$productImg");

        $productPrice = $_POST['productPrice'];
        $productDesc = $_POST['productDesc'];
        $productQTY = $_POST['productQTY'];

        $adminInsert = "insert into products (productTitle, productPrice, productDesc, productImg, productQTY) values ('$productTitle','$productPrice','$productDesc','$productImg','$productQTY')";

        $insert_prod = mysqli_query($dbcon, $adminInsert);

        if($insert_prod){

          echo "<script>alert('Produkten har skapats!')</script>";
          echo "<script>window.open('index.php?adminInsert','_self' )</script>";
        }
    }

?>