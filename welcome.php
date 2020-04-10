<?php
///include database configuration and database functions.
include_once('php functions/config.php');
include_once('php functions/database.php');

///start session to read username.
session_start();
///open database connection.
$conn = ConnectionOpen($databaseServer, $databaseUsername, $databasePassword);
///get user's datas from database. 
$user = GetUser($conn, $_SESSION["username"]);
///close database cinnection.
ConnectionClose($conn);
///show a message to user.
echo "Hi " . $user["firstName"] . " " . $user["lastName"];