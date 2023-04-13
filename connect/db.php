<?php

$db = require 'conf.php';
require 'rb-mysql.php';

const ROOT = '/qqb-ca/';

R::setup($db['dsn'], $db['user'], $db['pass']);