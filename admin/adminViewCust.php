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
            <td colspan="6"><h3>Visa alla kunder</h3></td>
        </tr>

        <tr align="center">
            <th>Namn</th>
            <th>E-post</th>
            <th>Bild</th>
            <th>Ta bort</th>
        </tr>

        <?php
        global $dbcon;

        $getCust = "select * from customers";
        $runCust = mysqli_query($dbcon, $getCust);

        while($rowCust=mysqli_fetch_array($runCust)){

            $custID = $rowCust['customerID'];
            $custName = $rowCust['customerName'];
            $custEmail = $rowCust['customerEmail'];
            $custImg = $rowCust['customerImg'];




            ?>

            <tr align="center">
                <td><hr><?php echo $custName; ?></td>
                <td><hr><?php echo $custEmail; ?></td>
                <td><hr><img src="../customer/img/<?php echo $custImg; ?>" width="50" height="60"/></td>
                <td><hr><a href="adminDeleteCust.php?adminDeleteCust=<?php echo $custID; ?>">Ta bort</a></td>
            </tr>
        <?php  } ?>
    </table>

</form>


