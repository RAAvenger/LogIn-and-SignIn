<?php
///mysql database functions.

///get "Server address" and user account's "Username" and "Password" of database then open a connection to database.
function ConnectionOpen($databaseServer, $databaseUsername, $databasePassword)
{
    ///create connection.
    $conn = new mysqli($databaseServer, $databaseUsername, $databasePassword);
    ///if connection failed show message.
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ///return connection
    return $conn;
}

///get "database connection" then close it.
function ConnectionClose($conn)
{
    ///close connection.
    $conn->close();
}

///get "database connection" and user's "username", "password", "firstName", "lastName", "phoneNumber", "email" and "birthDay" then add the user to database.
function AddNewUser($conn, $username, $password, $firstName, $lastName, $phoneNumber, $email, $birthDay)
{
    ///get date and time of now.
    $dateNow = date("yy-m-d h:m:s");
    ///sql query to insert "user" to database.
    $sql = "INSERT INTO loginproj.users (`id`, `username`, `password`, `firstName`, `lastName`, `phoneNumber`, `email`, `birthDay`, `createdAt`) 
    VALUES (NULL, '$username', '$password', '$firstName', '$lastName', '$phoneNumber', '$email', '$birthDay', '$dateNow');";
    ///execute sql query and if it was "OK" then return "1".
    if ($conn->query($sql) === true)
        return 1;
    ///if something go wrong then return "error"
    else
        return $sql . " " . $conn->error;
}

///get a string then make it safe to use.
function test_input($data)
{
    ///trim string.
    $data = trim($data);
    ///remove slashes.
    $data = stripslashes($data);
    ///make html special chars unexecutable.
    $data = htmlspecialchars($data);
    ///return string.
    return $data;
}

///get "database connection" and User's "username", "phoneNumber" and "email" then check if User's "username", "phoneNumber" and "email" Already Exists in database.
function NewUserAlreadyExists($conn, $username, $phoneNumber, $email)
{
    try {
        ///sql query to check if User's username already exists.
        $sql = "SELECT EXISTS(
                SELECT *
                FROM loginproj.users
                WHERE (users.username = '$username')
            ) AS 'result'";
        ///execute query and save "query result" in "$result".
        $result = $conn->query($sql);
        ///if User's "username" already exists return "-2". 
        if ($result->fetch_assoc()['result'] == 1) {
            return -2;
        }
        ///sql query to check if User's "phoneNumber" already exists.
        $sql = "SELECT EXISTS(
                SELECT *
                FROM loginproj.users
                WHERE (users.phoneNumber = '$phoneNumber')
            ) AS 'result'";
        ///execute query and save "query result" in "$result".
        $result = $conn->query($sql);
        ///if User's "phoneNumber" already exists return "-3".
        if ($result->fetch_assoc()['result'] == 1) {
            return -3;
        }
        ///sql query to check if User's "email" already exists.
        $sql = "SELECT EXISTS(
                SELECT *
                FROM loginproj.users
                WHERE (users.email = '$email')
            ) AS 'result'";
        ///execute query and save "query result" in "$result".
        $result = $conn->query($sql);
        ///if User's "email" already exists return "-4".
        if ($result->fetch_assoc()['result'] == 1) {
            return -4;
        }
    }
    ///return "-1" if unexpected error occur.
    catch (\Throwable $th) {
        return -1;
    } catch (\Exception $e) {
        return -1;
    }
    return 1;
}

///get "database connection" and User's "username" and "password" then check if user is "valid".
function UserValidation($conn, $username, $password)
{
    try {
        ///sql query to select password of user with "username = $username".
        $sql = "SELECT password
                FROM loginproj.users
                WHERE (users.username = '$username');
            ";
        ///execute query and save "query result" in "$result".
        $result = $conn->query($sql);
        ///if user with "username = $username" exists then check password.
        if ($result->num_rows > 0) {
            ///get "hash of User's password" from query result.
            $userPassword = $result->fetch_assoc()["password"];
            ///if "$password" is "right" return "1".
            if (password_verify($password, $userPassword) === true)
                return 1;
        }
    }
    ///return "-1" if unexpected error occur.
    catch (\Throwable $th) {
        return -1;
    } catch (\Exception $e) {
        return -1;
    }
    ///if "$username" did not existes in database or "$password" was "wrong" return "-2";
    return -2;
}

///get "database connection" and User's "username" then return "all user's datas". 
function GetUser($conn, $username)
{
    ///sql query to select all datas of User with "username = $username" 
    $sql = "SELECT *
            FROM loginproj.users
            WHERE (users.username = '$username');
            ";
    ///execute query and save "query result" in "$result".
    $result = $conn->query($sql);
    ///return "query result".
    return $result->fetch_assoc();
}
