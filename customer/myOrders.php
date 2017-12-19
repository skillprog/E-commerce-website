<?php

/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-12-10
 * Time: 20:31
 */

include ("../db/dbconnection.php");
?>

    <h3>Dina ordrar!</h3><br>
    <?php
    $user = $_SESSION['customerEmail'];

    $getCust = "select * from customers WHERE customerEmail='$user'";


    $runCust = mysqli_query($dbcon,$getCust);
    $rowCust = mysqli_fetch_array($runCust);

    $custID = $rowCust['customerID'];

    $getOrders = "select * from orders where customerID=$custID";
    $runOrders = mysqli_query($dbcon,$getOrders);

    //$i = 0;
    while($rowOrders=mysqli_fetch_array($runOrders)) {

        $orderID = $rowOrders['orderID'];
        $prodID = $rowOrders['productID'];
        $orderQTY = $rowOrders['orderQTY'];
        $orderPrice = $rowOrders['orderPrice'];

        $orderPriceAdj = $orderPrice*$orderQTY;

        $getProd = "select * from products WHERE productID=$prodID";
        $runProd = mysqli_query($dbcon, $getProd);

        $rowProds = mysqli_fetch_array($runProd);

        $prodImg = $rowProds['productImg'];
        $prodTitle = $rowProds['productTitle'];
        //$i++;



    ?>
        <table align="center" width="600px">
            <tr>
                <!--<td><h2>Din order: </h2></td> -->
                <td>
                    <?php echo $prodTitle; ?>
                    <img src="../admin/prod_img/<?php echo $prodImg; ?>" width="50" height="50"/>
                </td>
                <td>
                    Order antal: <?php echo $orderQTY; ?>
                </td>
                <td>
                    Kostnad: <?php echo $orderPriceAdj; ?>
                </td>
                <hr>
            </tr>

        </table>

        <hr>
   <?php } ?>


