<?php
/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-11-12
 * Time: 22:20
 */

include("admindbcon.php");

?>


        <form action="adminView.php" method="post" enctype="multipart/form-data">

            <table align="center" width="75%">

                <tr align="center">
                    <td colspan="6"><h3>Visa alla produkter</h3></td>
                </tr>

                <tr align="center">
                    <th>Titel</th>
                    <th>Bild</th>
                    <th>Pris</th>
                    <th>Antal</th>
                    <th>Redigera</th>
                    <th>Ta bort</th>
                </tr>

                <?php
                global $dbcon;

                $getProds = "select * from products";
                $runProds = mysqli_query($dbcon, $getProds);

                while($rowProds=mysqli_fetch_array($runProds)){

                    $prodsID = $rowProds['productID'];
                    $prodsTitle = $rowProds['productTitle'];
                    $prodsImg = $rowProds['productImg'];
                    $prodsPrice = $rowProds['productPrice'];
                    $prodsQTY = $rowProds['productQTY'];



                ?>

                <tr align="center">
                    <td><hr><?php echo $prodsTitle; ?></td>
                    <td><hr><img src="prod_img/<?php echo $prodsImg ?>" width="50" height="60"/></td>
                    <td><hr><?php echo $prodsPrice ?></td>
                    <td><hr><?php echo $prodsQTY ?></td>
                    <td><hr><a href="index.php?adminEdit=<?php echo $prodsID; ?>">Redigera</a></td>
                    <td><hr><a href="adminDelete.php?adminDelete=<?php echo $prodsID; ?>">Ta bort</a></td>
                </tr>
                <?php  } ?>
            </table>

        </form>


