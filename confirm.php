<?php

require 'connect/db.php';

$credit = R::load('credit', $_POST['id']);
$credit['status'] = 'yuborilgan';
R::store($credit);
