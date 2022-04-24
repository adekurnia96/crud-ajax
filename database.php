<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'ajax';

$link = mysqli_connect($host, $user, $pass, $db) or die(mysqli_error());

$_SESSION["user"] = 1;
