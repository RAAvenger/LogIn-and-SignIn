<?php
function ConnectionOpen($databaseServer, $databaseUsername, $databasePassword)
{
    $conn = new mysqli($databaseServer, $databaseUsername, $databasePassword);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function ConnectionClose($conn)
{
    $conn->close();
}

function AddNewUser($conn, $username, $password, $firstName, $lastName, $phoneNumber, $email, $birthDay)
{
    $dateNow = date("yy-m-d h:m:s");
    $sql = "INSERT INTO loginproj.users (`id`, `username`, `password`, `firstName`, `lastName`, `phoneNumber`, `email`, `birthDay`, `createdAt`) 
    VALUES (NULL, '$username', '$password', '$firstName', '$lastName', '$phoneNumber', '$email', '$birthDay', '$dateNow');";
    if ($conn->query($sql) === true)
        return 1;
    else
        return $sql . " " . $conn->error;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }