<?php

//include 'connect.php';
include 'functions/funcs.php';

session_start();

?>

<?php
//if(isset($_SESSION['customerEmail'])){

//    $custEmail =  $_SESSION['customerEmail'];
//}
global $dbcon;
$flagComment = "";



if(isset($_POST['sendReviews']) and $_SESSION['customerEmail']){


    $prodsID = $_GET['prods_id'];

    if ($_POST['comment'] != "" and $_POST['reviewNum']) {

        $custEmail = $_SESSION['customerEmail'];
        $flagCustomerID = "(select customerID from customers where customerEmail='$custEmail')";

        $flagComment = ($_POST['comment']);
        $flagReview = ($_POST['reviewNum']);

        $insertRev = "insert into reviews (customerID, productID, rating, review) VALUES ($flagCustomerID,$prodsID,$flagReview,'$flagComment')";

        mysqli_query($dbcon, $insertRev);

    }

}

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
            <li><a href="cart.php">Kundvagn</a></li>
        </ul>

    </div>
    <!-- end navigation menu -->

    <!-- <div id=sidemenu>
        <p>This will be sidemenu</p>
     </div> -->

    <div id=content>

        <div id="cartstyle">

            <span style=" font-size: 20px; padding: 5px;">


                 <?php

                 if(isset($_SESSION['customerEmail'])){

                     echo "<b style='color:white'>Välkommen</b>" . $_SESSION['customerEmail'];
                 }else{
                     echo "<b style='color:white'>Välkommen gäst!</b>";
                 }

                 ?>
                <a style="float: right; margin-right: 10px; color: yellow" href="cart.php">Din kundvagn</a>



            </span>

        </div>

        <div id="productBox">
            <?php //getDetailProds();


            global $dbcon;

            if (isset($_GET['prods_id'])) {


                $productID = $_GET['prods_id'];

                $getProds = "select * from products WHERE productID='$productID'";

                $run_getProds = mysqli_query($dbcon, $getProds);


                while ($row_Prods = mysqli_fetch_array($run_getProds)) {

                    $prods_id = $row_Prods['productID'];
                    $prods_title = $row_Prods['productTitle'];
                    $prods_price = $row_Prods['productPrice'];
                    $prods_desc = $row_Prods['productDesc'];
                    $prods_img = $row_Prods['productImg'];

                if(isset($_SESSION['customerEmail'])) {
                    echo "

            <div id='singleproduct'>
                <h2>$prods_title</h2>
                <img src='admin/prod_img/$prods_img' width='400' height='300' />
                <br><br>
                <p><b>$prods_price</b>kr</p>
                <br>
                <p>$prods_desc</p>
                <br>
                <a href='index.php'><button style='float: left;'>Tillbaka</button></a>

                <a href='index.php?cartADD=$prods_id'><button style='float: right;'>Lägg i kundvagn</button></a>


            </div>";
                } else {
                    echo "

            <div id='singleproduct'>
                <h2>$prods_title</h2>
                <img src='admin/prod_img/$prods_img' width='400' height='300' />
                <br><br>
                <p><b>$prods_price</b>kr</p>
                <br>
                <p>$prods_desc</p>
                <br>
                <a href='index.php'><button style='float: left;'>Tillbaka</button></a>

              


            </div>";
                }

                }
            }
            ?>

            <div id="singleproduct">
                <form action='' method='post'>
                    <br><br>
                    <p>1 = dåligt. 5 = bra.</p>
                    <input type='number' min='1' max='5' name='reviewNum' id='reviewNum' required/>
                    <textarea placeholder='Skriv en kommentar och lämna betyg!' style='float: right' rows='5' cols='35' name='comment' id='comment'></textarea>
                    <br><br><br>
                    <button type='submit' name='sendReviews'>Skicka</button>
                </form>
            </div>


            <?php getComment(); ?>

        </div>

    </div> <!-- end content -->

</div> <!-- end wrapper -->

<div id=footer>
    <p>footer</p>
</div>


</body>

</html>