<?php
//var_dump($_REQUEST);
include_once('config.php');
include_once('database.php');

$conn = ConnectionOpen($databaseServer, $databaseUsername, $databasePassword);
$resp = AddNewUser(
    $conn,
    $_REQUEST["username"],
    $_REQUEST["password"],
    $_REQUEST["firstName"],
    $_REQUEST["lastName"],
    $_REQUEST["phoneNumber"],
    $_REQUEST["email"],
    $_REQUEST["birthDay"]
);
echo ("$resp");
ConnectionClose($conn);
