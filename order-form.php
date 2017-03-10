<?php

if (!isset($_GET['orderNumber'])){
	die('null');
}

$pdo = new PDO('mysql:host=localhost;dbname=3waN12', '3waN12', '3waN12');
$pdo->exec('SET NAMES UTF8');

$query = $pdo->prepare
(
    'SELECT *, ROUND(quantityOrdered * priceEach, 2) AS total
     FROM `orderdetails`
     INNER JOIN products ON  orderdetails.productCode  = products.productCode
     WHERE orderNumber = :singe'
);
$query->execute(['singe'=>$_GET['orderNumber']]);
$orderDetails = $query->fetchAll(PDO::FETCH_ASSOC);


$query = $pdo->prepare
(
    'SELECT customerName, contactFirstName, contactLastName, addressLine1, addressLine2, city
     FROM `customers`
     INNER JOIN orders ON  orders.customerNumber  = customers.customerNumber
     WHERE orderNumber = :singe'
);
$query->execute(['singe'=>$_GET['orderNumber']]);
$customersInfo = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($customersInfo) == 0){
	die('...');
}
$customersInfo = $customersInfo[0];
// var_dump($customersInfo);
include 'order-form.phtml';
// productName AS Product
?>