<?php
$user['username'] = $user['password'] = '""';
$eRROR = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once('php functions/database.php');
    include_once('php functions/config.php');

    $user['username'] = test_input($_POST["username"]);
    $user['password'] = test_input($_POST["password"]);
    ///open connection
    $conn = ConnectionOpen($databaseServer, $databaseUsername, $databasePassword);
    switch (UserValidation($conn, $user['username'], $user['password'])) {
        case 1:
        {
            ///valid username and password
            break;
        }
        case -1:
        {
            ///unexpected error
            echo("error");
            break;
        }
        case -2:
        {
            ///invalid username or password
            $eRROR = "invalid username or password";
            break;
        }
    }
    ///close connection
    ConnectionClose($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/log%20in%20style%20.css">
    <script src="scripts/logInScript.js"></script>
    <title>Log In</title>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")
        echo "<script>InsertStyle();</script>";
    ?>
</head>

<body class="contaner">
<header>
    <h1>Hi</h1>
    <h2>welcome</h2>
</header>
<form title="sign in" id="formSignIn" action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
      class="form">
    <div class="title">
        <P>
            title
        </P>
    </div>
    <div class="explanations">
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
            dolore
            magna aliqua.
            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat.
        </p>
    </div>
    <div class="input-box">
        <label for="username">Usermame:</label>
        <input type="text" name="username" id="username" value=<?php echo $user["username"]; ?> pattern="\w{5,}$"
               maxlength="25" required>
    </div>
    <?php
    if ($eRROR !== "") {
        echo("<div class=\"invalidInput\"> <p>");
        echo($eRROR);
        echo("</p> </div>");
    }
    ?>
    <div class="input-box">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value="<?php echo true?$user["password"]:""; ?>" pattern="\w{8,}$"
               maxlength="30" required>
        <img src="images/Eye_48px.png" onclick="PasswordShow_Hide(this,'password')" alt="show"
             style="height: 19px; width: 22px; margin: auto; padding:3px">
    </div>
    <button class="button" onclick="return formValidate('formSignIn')">submit</button>
</form>
<footer>
    <p>goodbye</p>
    <a href="http://Loremipsumdolor.sit">contact us</a>
    <p id="jsResp"></p>
</footer>

<?php
if ($eRROR !== "") {
    echo("<script>InvalidInput('username', '" . $eRROR . "');</script>");
    echo("<script>InvalidInput('password', '" . $eRROR . "');</script>");
}
?>
</body>
</html>