<?php

$db = require 'conf.php';
require 'rb.php';

const ROOT = 'http://project.loc/';

R::setup($db['dsn'], $db['user'], $db['pass']);