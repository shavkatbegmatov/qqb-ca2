<?php

require '../connect/db.php';

$credit = R::findOne('credit', 'id = ?', [$_GET['id']]);

$array = $credit['cr_file_1'] . ',' .
	$credit['cr_file_2'] . ',' .
	$credit['cr_file_3'] . ',' .
	$credit['cr_file_4'] . ',' .
	$credit['cr_file_5'] . ',' .
	$credit['cr_file_6'];

echo $array;
