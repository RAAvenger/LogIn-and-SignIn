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

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function NewUserAlreadyExists($conn, $username, $phoneNumber, $email)
{
    try {
        $t = 1 / 0;
        $sql = "SELECT EXISTS(
                SELECT *
                FROM loginproj.users
                WHERE (users.username = '$username')
            ) AS 'result'";
        $result = $conn->query($sql);
        if ($result->fetch_assoc()['result'] == 1) {
            return -2;
        }
        $sql = "SELECT EXISTS(
                SELECT *
                FROM loginproj.users
                WHERE (users.phoneNumber = '$phoneNumber')
            ) AS 'result'";
        $result = $conn->query($sql);
        if ($result->fetch_assoc()['result'] == 1) {
            return -3;
        }
        $sql = "SELECT EXISTS(
                SELECT *
                FROM loginproj.users
                WHERE (users.email = '$email')
            ) AS 'result'";
        $result = $conn->query($sql);
        if ($result->fetch_assoc()['result'] == 1) {
            return -4;
        }
    } catch (\Throwable $th) {
        return -1;
    } catch (\Exception $e) {
        return -1;
    }
    return 1;
}
