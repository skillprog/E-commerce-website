<?php

session_start();

//include 'connect.php';
//include 'db/dbconnection.php';
include 'functions/funcs.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datanördarna</title>
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" >
    <!--  <link rel="stylesheet" type="text/css" media="screen" href="bootstrap/css/bootstrap.css">
      <link rel="stylesheet" type="text/css" media="screen" href="bootstrap/css/bootstrap-responsive.css">
      <link rel="stylesheet" type="text/css" media="screen" href="bootstrap/js/bootstrap.js"> -->
</head>

<body>

<!-- start page-wrapper -->
<div class=wrapper>

    <!-- navigation menu -->
    <div class="header">


        <ul id="menu">
            <li><a href="index.php">Hem</a></li>
            <li><a href="custRegister.php">Registrera dig</a></li>
            <li><a href="#" class='active-page'>Kundvagn</a></li>
            <br><br>
            <li><a href="customer/custProfile.php">Min profil</a></li>
        </ul>


    </div>
    <!-- end navigation menu -->



    <div id=contentCart>



        <div id="cartstyle">

            <span style=" font-size: 20px; padding: 5px;">

                <b style="color:white">Välkommen gästanvändare!</b>
                <a style="float: right; margin-right: 10px; color: yellow" href="index.php">Tillbaka</a>

                <?php
                if(!isset($_SESSION['customerEmail'])){

                    echo "<a style='color: yellow; text-decoration: none' href='checkout.php'>Logga in</a>";

                }else{

                    echo "<a style='color: yellow; text-decoration: none' href='logout.php'>Logga ut</a>";
                }
                ?>

            </span>

        </div>

        <div id="productBoxCart">
            <br> <br>
            <form>

                <table align="center" width="90%">

                    <tr align="center">
                        <th>Ta bort</th>
                        <th>Produkt</th>
                        <th>Antal</th>
                        <th>Kostnad</th>
                    </tr>
                </table>
            </form>
            <?php

            global $dbcon;
            $total = 0;

            $getUser = $_SESSION['customerEmail'];
            //echo $getUser;
            $getID = "(SELECT customerID FROM customers WHERE customerEmail='$getUser')";

            $getProds = "SELECT productID, cartID FROM cart WHERE customerID=($getID)";
            $runGetProds = mysqli_query($dbcon, $getProds);

            while ($rowProds = mysqli_fetch_array($runGetProds)){

                $cartsID = $rowProds['cartID'];
                $prodsID = $rowProds['productID'];

                $prodsQuery = "select * from products WHERE productID=$prodsID";

                $runProdsQuery = mysqli_query($dbcon,$prodsQuery);

                while ($rowItems = mysqli_fetch_array($runProdsQuery)) {

                    $productID = $rowItems['productID'];
                    $productTitle = $rowItems['productTitle'];
                    //$productPrice = array($rowPrices['productPrice']);
                    $productImage = $rowItems['productImg'];

                    //De insatta antalet i lager.
                    $productQTY = $rowItems['productQTY'];

                    $getCartQty = "select * from cart where productID=$productID";
                    $cartQty = mysqli_query($dbcon, $getCartQty);
                    //nuvarande antal i kundvagnen.
                    $fetchQty = mysqli_fetch_assoc($cartQty);
                    $productPrice = $fetchQty['prodPrice'];
                    $prodQTY = $fetchQty['prodQTY'];

                    //$fetchedQty = $fetchQty['$prodQTY'];

                    //$fetchedValues = array_sum($productPrice);
                    $total = $total+ ($productPrice * $prodQTY);
                    //$total = $total + $productPrice;


                    echo "<div>
                                                                                          
                                    <table>
                                      <tr align='center'>
                                      
                                        <td>
                                            <button><a href='cart.php?removeFromCart=$cartsID'>Ta bort</a></button>
                                        </td>
                                        <td>
                                            <b><p>$productTitle</p></b><br><img src='admin/prod_img/$productImage' width='120' height='120'/> 
                                                
                                        </td>
                                      </tr>
                                    </table>
                                    
                                    <form method='post' action='cart.php'>
                                         <table>
                                            <td>
                                                <input type='number' value=".$fetchQty['prodQTY']." name='cartQty' min='1' max='$productQTY'/>
                                                <input type='hidden' name='hidden' value='$productID'/>
                                                <td><button type='submit' name='updateCart'>Skicka</button></td>                                         
                                              
                                            </td>
                                         </table>
                                    </form>
                                   
                                    <p>$productPrice kr</p>
  
                                  </div>";


                }
            }
            if (isset($_POST['updateCart'])) {
                $updateQty = "update cart set prodQTY='$_POST[cartQty]' WHERE productID='$_POST[hidden]'";
                mysqli_query($dbcon, $updateQty);

            }

            echo "   
                    <table>
                        <tr align='right'>
                            <td colspan='4'><b>Totalkostnad: </b></td>
                            <td colspan='4'>$total kr</td>
                        </tr>
                        <a href='cart.php?sendOrder=$getUser' style='text-decoration: none; color:black'><input type='submit' value='köp'/></a>
                    </table>";

            ?>

            <?php

            global $dbcon;
            $getUser = $_SESSION['customerEmail'];

            if (isset($_GET['removeFromCart'])) {

                $cartsID = $_GET['removeFromCart'];

                $getID = "(SELECT customerID FROM customers WHERE customerEmail='$getUser')";

                $deleteProd = "DELETE FROM cart WHERE cartID='$cartsID'";
                $rundelete = mysqli_query($dbcon, $deleteProd);

                if ($rundelete) {
                    echo "<script>window.open('cart.php','_self')</script>";
                }
            }

            //if (isset($_POST['continue'])) {
            //   echo "<script>window.open('index.php','_self')</script>";
            //}

            ?>

            <!-- för att checka ut kundvagnen och ordna kvantiteten av produkterna korrekt i products tabellen -->
            <?php

            if(isset($_GET['sendOrder'])){

                $getUserEmail = $_GET['sendOrder'];
                $getUserID = "(select customerID from customers where customerEmail='$getUserEmail')";

                $insertOrder = "insert into orders (productID, orderQTY, orderPrice, customerID) SELECT productID, prodQTY, prodPrice, customerID FROM cart WHERE customerID=$getUserID";
                //$insertOrder = "insert into orders (productID, orderQTY, orderPrice, customerID) SELECT s.productID, s.orderQTY, a.orderPrice, s.customerID FROM (SELECT * FROM cart WHERE customerID = $getUserID) s JOIN products a ON a.productID=s.productID";

                $getProdID = "select productID from cart WHERE customerID=$getUserID";
                $runGetProdID = mysqli_query($dbcon,$getProdID);

                //felkoll
                while($getArray = mysqli_fetch_array($runGetProdID,MYSQLI_NUM)){
                    $value = $getArray[0];
                    $cartQTY = "(select prodQTY from cart where productID=$value)";
                    $prodQTY = "(select productQTY from products where productID=$value)";

                    $cartQuery = mysqli_query($dbcon,$cartQTY);
                    $prodQuery = mysqli_query($dbcon,$prodQTY);

                    $cartArray = mysqli_fetch_array($cartQuery,MYSQLI_NUM);
                    $prodArray = mysqli_fetch_array($prodQuery, MYSQLI_NUM);

                    if($cartArray[0] > $prodArray[0]) {
                        return 0;
                    }
                }
                $runGetProdID = mysqli_query($dbcon,$getProdID);

                while($getArray = mysqli_fetch_array($runGetProdID,MYSQLI_NUM)){
                    $value = $getArray[0];
                    $sendOrderQTY = "(select prodQTY from cart where productID=$value)";
                    $diffQTY = "UPDATE products SET productQTY = productQTY - $sendOrderQTY WHERE productID=$value";
                    mysqli_query($dbcon,$diffQTY);
                }
                mysqli_query($dbcon,$insertOrder);

                $removeCart = "DELETE FROM cart WHERE customerID=$getID";
                mysqli_query($dbcon,$removeCart);

                echo "<script>alert('Köp genomfört!')</script>";
                echo "<script>window.open('cart.php','_self')</script>";
            }

            ?>


        </div> <!-- end productbox -->

    </div> <!-- end content -->

</div> <!-- end wrapper -->

<div id=footer>
    <p>footer</p>
</div>


</body>

</html>