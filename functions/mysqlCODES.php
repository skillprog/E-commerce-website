<?php
/**
 * Created by PhpStorm.
 * User: antonkarmeborg
 * Date: 2017-12-11
 * Time: 22:29
 */
?>

create table cart (
    cartID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    prodPrice int NOT NULL,
    prodQTY int NOT NULL,
    productID int,
    customerID int,
    FOREIGN KEY (customerID) REFERENCES customers(customerID) ON DELETE CASCADE,
    FOREIGN KEY (productID) REFERENCES products(productID) ON DELETE CASCADE
)

create table orders (
    orderID int PRIMARY KEY AUTO_INCREMENT,
    productID int,
    orderQTY int,
    orderPrice int,
    orderDate DATETIME,
    customerID int,
    FOREIGN KEY (customerID) REFERENCES customers(customerID) ON DELETE CASCADE,
    FOREIGN KEY (productID) REFERENCES products(productID) ON DELETE CASCADE
)
