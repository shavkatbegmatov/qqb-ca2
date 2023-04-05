<?php

require '../connect/db.php';

$credit = R::load('credit', $_GET['id']);
$credit['status'] = 'tastiqlangan';
R::store($credit);

$notification = R::dispense('notification');
$notification['user_id'] = R::findOne('credit', 'id = ?', [$_GET['id']])['client_id'];
$notification['text'] = 'Sizning ' . $_GET['id'] . '-chi kreditingiz tastiqlandi :)';
R::store($notification);

header('Location: index.php');
