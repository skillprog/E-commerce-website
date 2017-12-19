<?php
/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-11-12
 * Time: 22:20
 */

include("admindbcon.php");
global $dbcon;

if(isset($_GET['adminEdit'])) {

    $getID = $_GET['adminEdit'];

    $getProds = "select * from products where productID=$getID";
    $runProds = mysqli_query($dbcon, $getProds);


    $rowProds = mysqli_fetch_array($runProds);

    $prodsID = $rowProds['productID'];
    $prodsTitle = $rowProds['productTitle'];
    $prodsImg = $rowProds['productImg'];
    $prodsPrice = $rowProds['productPrice'];
    $prodsQTY = $rowProds['productQTY'];
    $prodsDesc = $rowProds['productDesc'];
}

    ?>

            <form action="" method="post" enctype="multipart/form-data">

                <table align="center" width="50%">

                    <tr align="center">
                        <td colspan="6"><h2>Redigera produkt</h2></td>
                    </tr>


                    <tr align="center">
                        <td>Titel för produkt:</td>
                        <td><input type="text" name="productTitle" value="<?php echo $prodsTitle; ?>"/></td>
                    </tr>

                    <tr align="center">
                        <td>Bild för produkt:</td>
                        <td><input type="file" name="productImg"/><img src="prod_img/<?php echo $prodsImg; ?>" width="50" height="60" </td>
                    </tr>

                    <tr align="center">
                        <td>Pris för produkt:</td>
                        <td><input type="text" name="productPrice" value="<?php echo $prodsPrice; ?>"/></td>
                    </tr>

                    <tr align="center">
                        <td>Beskriving av produkt:</td>
                        <td><textarea name="productDesc" cols="10" rows="5"><?php echo $prodsDesc; ?></textarea></td>
                    </tr>

                    <tr align="center">
                        <td>Antal av produkt</td>
                        <td><input type="number" name="productQTY" min="1" max="10" value="<?php echo $prodsQTY; ?>"></td>
                    </tr>

                    <tr align="center">
                        <td><input type="submit" name="updateProd" value="Uppdatera produkt"/></td>
                    </tr>


                </table>

            </form>




    <?php

//get text/data from fields and send through POST.
    if (isset($_POST['updateProd'])) {

        $updID = $prodsID;
        $productTitle = $_POST['productTitle'];
        $productImg = $_FILES['productImg']['name'];
        $productImg_tmp = $_FILES['productImg']['tmp_name'];
        move_uploaded_file($productImg_tmp, "prod_img/$productImg");

        $productPrice = $_POST['productPrice'];
        $productDesc = $_POST['productDesc'];
        $productQTY = $_POST['productQTY'];

        $updateProd = "update products set productTitle='$productTitle',productPrice='$productPrice',productDesc='$productDesc',productImg='$productImg',productQTY='$productQTY' WHERE productID='$updID'";
        $runProd = mysqli_query($dbcon, $updateProd);

        if ($runProd) {

            echo "<script>alert('Produkten har uppdaterats!')</script>";
            echo "<script>window.open('index.php?adminView','_self' )</script>";
        }

}
?>