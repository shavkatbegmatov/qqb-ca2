<?php

$db = require 'conf.php';
require 'rb.php';

R::setup($db['dsn'], $db['user'], $db['pass']);