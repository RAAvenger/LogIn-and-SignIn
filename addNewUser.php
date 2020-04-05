<?php
//var_dump($_REQUEST);
include_once('config.php');
include_once('database.php');

$conn = ConnectionOpen($databaseServer, $databaseUsername, $databasePassword);
$user['username'] = test_input($_POST["username"]);
$user['password'] = password_hash(test_input($_POST["password"]), PASSWORD_ARGON2I);
$user['firstName'] = test_input($_POST["firstName"]);
$user['lastName'] = test_input($_POST["lastName"]);
$user['phoneNumber'] = test_input($_POST["phoneNumber"]);
$user['email'] = test_input($_POST["email"]);
$user['birthDay'] = test_input($_POST["birthDay"]);
switch (NewUserAlreadyExists($conn, $user['username'], $user['phoneNumber'], $user['email'])) {
    case 1: {
            $resp = AddNewUser(
                $conn,
                $user['username'],
                $user['password'],
                $user['firstName'],
                $user['lastName'],
                $user['phoneNumber'],
                $user['email'],
                $user['birthDay']
            );
            echo ("$resp");
            break;
        }
    case -1: {
            echo ("error");
            break;
        }
    case -2: {
            echo ("username exists");
            break;
        }
    case -3: {
            echo ("phoneNumber exists");
            break;
        }
    case -4: {
            echo ("email exists");
            break;
        }
}
// $sql = "select * from loginproj.users";
// $users = $conn->query($sql);
// while ($row = $users->fetch_assoc()) {
//     $pass = $row['password'];
//     if (password_verify(test_input($_POST["password"]), $row["password"]))
//         echo ("</br>true: $pass");
//     else
//         echo ("</br>false: $pass");
// }
ConnectionClose($conn);
