<?php

require '../connect/db.php';

$credit = R::load('credit', $_GET['id']);
$credit['status'] = 'radetilgan';
R::store($credit);

$notification = R::dispense('notification');
$notification['user_id'] = R::findOne('credit', 'id = ?', [$_GET['id']])['client_id'];
$notification['text'] = 'Sizning ' . $_GET['id'] . '-chi kreditingiz rad etildi :(';
R::store($notification);

header('Location: index.php');
