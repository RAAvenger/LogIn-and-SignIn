<?php
//var_dump($_REQUEST);
include_once('config.php');
include_once('database.php');

$conn = ConnectionOpen($databaseServer, $databaseUsername, $databasePassword);
$resp = AddNewUser(
    $conn,
    test_input($_POST["username"]),
    password_hash(test_input($_POST["password"]), PASSWORD_ARGON2I),
    test_input($_POST["firstName"]),
    test_input($_POST["lastName"]),
    test_input($_POST["phoneNumber"]),
    test_input($_POST["email"]),
    test_input($_POST["birthDay"])
);
echo ("$resp");
$sql = "select * from loginproj.users";
$users = $conn->query($sql);
while ($row = $users->fetch_assoc()) {
    $pass = $row['password'];
    if (password_verify(test_input($_POST["password"]), $row["password"]))
        echo ("</br>true: $pass");
    else
        echo ("</br>false: $pass");
}
ConnectionClose($conn);
