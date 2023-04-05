<?php

require 'connect/db.php';

session_start();

$credit = R::dispense('credit');
$credit['client_id'] = $_SESSION['user']['id'];
$credit['credit_type'] = $_POST['cr_type'];
$credit['credit_purpose'] = $_POST['cr_purpose'];
$credit['credit_sum'] = $_POST['cr_sum'];
$credit['credit_period'] = $_POST['cr_period'];
$credit['status'] = 'ochirilgan';
$credit_id = R::store($credit);

echo $credit_id;
