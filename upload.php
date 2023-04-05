<?php
require 'connect/db.php';

function randString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function fileExtension($name)
{
    $n = strrpos($name, '.');
    return ($n === false) ? '' : substr($name, $n + 1);
}

if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
} else {
    $randString = randString();
    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $randString . '.' . fileExtension($_FILES['file']['name']));

    $credit = R::load('credit', $_POST['cr_id']);
    $credit[$_POST['db_alias']] = $randString . '.' . fileExtension($_FILES['file']['name']);
    R::store($credit);
}
