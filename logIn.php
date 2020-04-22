<?php
///start session to read or write some of "User's datas".
session_start();
///allocating memory for User's "username" and "password".
$user['username'] = $user['password'] = '""';
///allocating memory for "error message".
$eRROR = "";
///check if we are "validating user" or just "loading page".
///if we are "validating user".
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ///include database configuration and database functions.
    include_once('php functions/config.php');
    include_once('php functions/database.php');

    ///get User's "username" and "password" by post method and set them to $user.
    $user["username"] = test_input($_POST["username"]);
    $user["password"] = test_input($_POST["password"]);
    ///open connection
    $conn = ConnectionOpen($databaseServer, $databaseUsername, $databasePassword);
    ///check User's "username" and "password".
    switch (UserValidation($conn, $user["username"], $user["password"])) {
            ///valid "username" and "password".
        case 1: {
                ///insert User's "username" to session.
                $_SESSION["username"] =  $user["username"];
                ///if user checked "Remember Me" then insert User's "password" and "rememberMe" to session.
                if (isset($_POST["rememberMe"])) {
                    $_SESSION["rememberMe"] = true;
                    $_SESSION["password"] = $user['password'];
                }
                ///else remove User's "password" and "rememberMe" from session if they exists in session.
                else {
                    if (isset($_SESSION["rememberMe"]))
                        unset($_SESSION["rememberMe"]);
                    if (isset($_SESSION["password"]))
                        unset($_SESSION["password"]);
                }
                ///go to welcome.php page.
                header("Location: welcome.php");
                break;
            }
            ///unexpected error.
        case -1: {
                // echo ("error");
                break;
            }
            ///invalid username or password
        case -2: {
                ///clear session.
                session_unset();
                ///set "error message".
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
    <link rel="stylesheet" href="styles/style.css">
    <script src="scripts/logInScript.js"></script>
    <title>Log In</title>
    <?php
    ///if "validating user" then Insert "vallide" and "invalide" styles. 
    if ($_SERVER["REQUEST_METHOD"] == "POST")
        ///run "InsertStyle" javaScript function.
        echo "<script>InsertStyle();</script>";
    ?>
</head>

<body class="contaner">
    <header>
        <h1>Hi</h1>
        <h2>welcome</h2>
    </header>
    <form title="sign in" id="formSignIn" action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form">
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
            <input type="text" name="username" id="username" value=<?php echo isset($_SESSION["rememberMe"]) ? $_SESSION["username"] : '""'; ?> pattern="\w{5,}$" maxlength="25" required>
        </div>
        <?php
        ///if "error message" is not empty then show "error message". 
        if ($eRROR !== "") {
            echo ("<div class=\"invalidInput\"> <p>");
            echo ($eRROR);
            echo ("</p> </div>");
        }
        ?>
        <div class="input-box">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="<?php echo isset($_SESSION["rememberMe"]) ? $_SESSION["password"] : '""'; ?>" pattern="\w{8,}$" maxlength="30" required>
            <img src="images/Eye_48px.png" onclick="PasswordShow_Hide(this,'password')" alt="show" style="height: 19px; width: 22px; margin: auto; padding:3px">
        </div>
        <div class="input-box">
            <label for="rememberMe" style="width: unset;flex-grow: 0;">Remember Me:</label>
            <input type="checkbox" name="rememberMe" id="rememberMe" value="true" style=" flex-grow: 0;width: unset; margin-inline: 10px" <?php echo isset($_SESSION["rememberMe"]) ? "checked" : ''; ?>>
        </div>
        <div class="helpOptions">
            <a href="">forgot your password?</a><br>
            <a href="signin.php">sign in</a>
        </div>
        <button class="button" onclick="return formValidate('formSignIn')">submit</button>
    </form>
    <footer>
        <p>goodbye</p>
        <a href="http://Loremipsumdolor.sit">contact us</a>
        <p id="jsResp"></p>
    </footer>

    <?php
    ///if User's "username" or "password" are not invalid make both them "invalid".
    if ($eRROR !== "") {
        ///run javaScript "InvalidInput" function for "username" and "password".
        echo ("<script>InvalidInput('username', '" . $eRROR . "');</script>");
        echo ("<script>InvalidInput('password', '" . $eRROR . "');</script>");
    }
    ?>
</body>

</html>