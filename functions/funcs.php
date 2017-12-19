<?php
/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-11-13
 * Time: 22:11
 */



$dbcon = new mysqli("localhost", "admin", "admin", "webshopdb");

function getProds()
{


    global $dbcon;

    $getProds = "select * from products";

    $run_getProds = mysqli_query($dbcon, $getProds);


    while ($row_Prods = mysqli_fetch_array($run_getProds)) {

        $prods_id = $row_Prods['productID'];
        $prods_title = $row_Prods['productTitle'];
        $prods_price = $row_Prods['productPrice'];
        //$prods_desc = $row_Prods['productDesc'];
        $prods_img = $row_Prods['productImg'];

        if (isset($_SESSION['customerEmail'])) {
            echo "
        
            <div id='singleproduct'>
                <h2>$prods_title</h2>
                <img src='admin/prod_img/$prods_img' width='200' height='200' />
                <p><b>$prods_price</b>kr</p>
                <br>
                <a href='details.php?prods_id=$prods_id'><button style='float: left;'>Info</button></a>       
                <a href='index.php?cartADD=$prods_id'><button style='float: right;'>Lägg i kundvagn</button></a>         
                </div>";
        } else {
            echo "
        
            <div id='singleproduct'>
                <h2>$prods_title</h2>
                <img src='admin/prod_img/$prods_img' width='200' height='200' />
                <p><b>$prods_price</b>kr</p>
                <br>
                <a href='details.php?prods_id=$prods_id'><button style='float: left;'>Info</button></a>                
                </div>";
        }
    }
}




function getDetailProds()
{

    global $dbcon;

    if (isset($_GET['prods_id'])) {

        $productID = $_GET['prods_id'];

        $getProds = "select * from products WHERE productID='$productID'";

        $run_getProds = mysqli_query($dbcon, $getProds);


        while ($row_Prods = mysqli_fetch_array($run_getProds)) {

            $prods_id = $row_Prods['productID'];
            $_SESSION['prodID'] = $prods_id;
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

}



function getComment(){


    global $dbcon;

    //$prods_id = $_SESSION['prodID'];

        //$prod_id = $_GET['prods_id'];

    if(isset($_GET['prods_id'])) {

        $prodID=$_GET['prods_id'];

        $getRev = "SELECT * FROM reviews WHERE productID='$prodID'";
        $runGetReview= mysqli_query($dbcon, $getRev);

        while ($rowReviews=mysqli_fetch_array($runGetReview)){

            $custID = $rowReviews['customerID'];
            $reviews = $rowReviews['review'];
            $likings = $rowReviews['rating'];

            $getCustName = "SELECT customerName FROM customers WHERE customerID=$custID";
            $runGetCust= mysqli_query($dbcon, $getCustName);

            while ($rowCust=mysqli_fetch_array($runGetCust)){

                $customerName = $rowCust['customerName'];

                echo"

                 <div id='singleproduct'>
                    <h2>$customerName</h2>
                    <br>
                    $reviews
                    <br>
                    <br>
                    <p>betyg: $likings/5</p>
                    <br />
                </div>
          ";
            }
        }
    }
}


function sendUserID(){
    //if(!isset($_SESSION['customerEmail'])){

     //   echo "<script>alert('Du måste logga in för att kunna göra detta!')</script>";
    //}else{

        $getUser = $_SESSION['customerEmail'];

        $getID = "(SELECT customerID FROM customers WHERE customerEmail='$getUser')";

        return $getID;
    //}

}


function cart(){

    global $dbcon;

    $getCart = "SELECT productID FROM cart";
    $doQuery = mysqli_query($dbcon, $getCart);

    if(isset($_GET['cartADD'])){

        $prods_id = $_GET['cartADD'];
        $flag = false;

        while($rowItems=mysqli_fetch_array($doQuery)){

            if($prods_id === $rowItems['productID']){
                $flag = true;
            }
        }
        if($flag !== true){

            $getID = sendUserID();
            $getPrice = "(SELECT productPrice FROM products WHERE productID='$prods_id')";


            //echo $getID;
            $insertCart = "INSERT INTO cart (prodPrice, prodQTY, productID, customerID) values ($getPrice, 1, $prods_id,$getID)";
            mysqli_query($dbcon, $insertCart);
            echo "<script>window.open('index.php','_self')</script>";
        }

    }

}

function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}


function totItems(){

    if (isset($_GET['cartADD'])){

        global $dbcon;

        $getID = sendUserID();

        $getItems = "select * from cart WHERE customerID='$getID'";

        $runItems = mysqli_query($dbcon, $getItems);

        $countItems = mysqli_num_rows($runItems);

    }

    else{

        global $dbcon;

        $getID = sendUserID();

        $getItems = "select * from cart WHERE customerID='$getID'";

        $runItems = mysqli_query($dbcon, $getItems);

        $countItems = mysqli_num_rows($runItems);

        }
    echo $countItems;

}

function totPrice(){

    $total = 0;

    global $dbcon;

    $getID = sendUserID();

    $getPrice = "select * from cart where customerID='$getID'";

    $runPrices = mysqli_query($dbcon, $getPrice);

    while ($rowProds = mysqli_fetch_array($runPrices)){

        $prodsID = $rowProds['productID'];

        $prodsPrice = "select * from products WHERE productID='$prodsID'";

        $runProdsPrice = mysqli_query($dbcon,$prodsPrice);

        while ($rowPrices = mysqli_fetch_array($runProdsPrice)){

                $productPrice = array($rowPrices['productPrice']);

                $fetchedValues = array_sum($productPrice);

                $total += $fetchedValues;
        }


    }

    echo $total . "kr";

}

function cartOrder(){

$total = 0;

global $dbcon;

//hämta den inloggade användarens customerID.
$getID = sendUserID();

$getProds = "SELECT productID, cartID FROM cart WHERE customerID=($getID)";

$runGetProds = mysqli_query($dbcon, $getProds);

if (isset($_POST['updateCart'])) {

    echo $updateQty = "update cart set prodQTY='$_POST[cartQty]' WHERE productID='$_POST[hidden]'";
    mysqli_query($dbcon, $updateQty);

}

while ($rowProds = mysqli_fetch_array($runGetProds)){

    $cartsID = $rowProds['cartID'];
    $prodsID = $rowProds['productID'];

    $prodsQuery = "select * from products WHERE productID='$prodsID'";

    $runProdsQuery = mysqli_query($dbcon,$prodsQuery);

    while ($rowItems = mysqli_fetch_array($runProdsQuery)) {

        $pID = $rowItems['productID'];
        $productTitle = $rowItems['productTitle'];
        //$productPrice = array($rowPrices['productPrice']);
        $productImage = $rowItems['productImg'];
        $productPrice = $rowItems['productPrice'];
        //De insatta antalet i lager.
        $productQTY = $rowItems['productQTY'];

        $getCartQty = "select * from cart where productID=$pID";
        $cartQty = mysqli_query($dbcon, $getCartQty);
        //nuvarande antal i kundvagnen.
        $fetchQty = mysqli_fetch_assoc($cartQty);

         $fetchedQty = $fetchQty['$prodQTY'];

        //$fetchedValues = array_sum($productPrice);
        $total = $total+ ($productPrice * $fetchQty['prodQTY']);
        //$total = $total + $productPrice;


        echo "<div>
                                                                                          
                                    
                                    <tr align='center'>
                                      
                                        <td>
                                            <button><a href='cart.php?removeFromCart=$cartsID'>Ta bort</a></button>
                                        </td>
                                        <td>
                                            <b><p>$productTitle</p></b><br><img src='admin/prod_img/$productImage' width='120' height='120'/> 
                                                
                                        </td>
                                        <td>
                                            <input type='number' value=".$fetchQty['prodQTY']." name='cartQty' min='1' max='$productQTY'/>
                                            <input type='hidden' name='hidden' value='$pID'/><p>produktid: $pID</p>
                                            <td><button type='submit' name='updateCart'>Skicka</button></td>                                         
                                          
                                        </td>
                                        <td>
                                            <p>$productPrice kr</p>
                                        </td>

                                     </tr>

                                  </div>";


    }
}

}
?>



