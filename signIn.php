<?php
///allocating memory for User's "username", "password", "passwordRep", "firstName", "lastName", "phoneNumber", "email" and "birthDay".
$user['username'] = $user['password'] = $user['passwordRep'] = $user['firstName'] = $user['lastName'] = $user['phoneNumber'] = $user['email'] = $user['birthDay'] = '""';
///allocating memory for "error message".
$eRROR = "";
///check if we are "validating user" or just "loading page".
///if we are "validating user".
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ///include database configuration and database functions.
    include_once('php functions/config.php');
    include_once('php functions/database.php');

    ///start session to write User's "username".
    session_start();
    ///get User's "username", "password", "passwordRep", "firstName", "lastName", "phoneNumber", "email" and "birthDay" by post method and set them to $user.
    $user['username'] = test_input($_POST["username"]);
    $user['password'] = password_hash(test_input($_POST["password"]), PASSWORD_ARGON2I);
    $user['passwordRep'] = $_POST["passwordRep"];
    $user['firstName'] = test_input($_POST["firstName"]);
    $user['lastName'] = test_input($_POST["lastName"]);
    $user['phoneNumber'] = test_input($_POST["phoneNumber"]);
    $user['email'] = test_input($_POST["email"]);
    $user['birthDay'] = test_input($_POST["birthDay"]);
    ///open connection
    $conn = ConnectionOpen($databaseServer, $databaseUsername, $databasePassword);
    ///check User's "username", "phoneNumber" and "email".
    switch (NewUserAlreadyExists($conn, $user['username'], $user['phoneNumber'], $user['email'])) {
            ///User's "username" and "phoneNumber" and "email" are not already exists in database.
        case 1: {
                ///if nothing wrong happen then add User's "username" to sesstion and go to "welcome.php".
                if (AddNewUser($conn, $user['username'], $user['password'], $user['firstName'], $user['lastName'], $user['phoneNumber'], $user['email'], $user['birthDay']) === 1) {
                    $_SESSION["username"] = $user['username'];
                    header("Location: welcome.php");
                }
                break;
            }
            ///unexpected error.
        case -1: {
                // echo ("error");
                break;
            }
            ///Username exists.
        case -2: {
                ///set "error message".
                $eRROR = "Username exists";
                break;
            }
            ///Phone Number exists.
        case -3: {
                ///set "error message".
                $eRROR = "Phone Number exists";
                break;
            }
            ///Email exists.
        case -4: {
                ///set "error message".
                $eRROR = "Email exists";
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
    <script src="scripts/signInScript.js"></script>
    <title>Sign in</title>
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
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                laborum.
            </p>
        </div>
        <div class="input-box">
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" id="firstName" value=<?php echo $user["firstName"]; ?> pattern="[A-Za-z]+" maxlength="40" required>
        </div>
        <div class="explanations">
            <p>
                Must contain only uppercase or lowercase letter.
            </p>
        </div>
        <div class="input-box">
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" id="lastName" value=<?php echo $user["lastName"]; ?> pattern="[A-Za-z]+" maxlength="60" required>
        </div>
        <div class="explanations">
            <p>
                Must contain only uppercase or lowercase letter.
            </p>
        </div>
        <div class="input-box">
            <label for="username">Usermame:</label>
            <input type="text" name="username" id="username" value=<?php echo $user["username"]; ?> pattern="\w{5,}$" maxlength="25" required>
        </div>
        <?php
        ///if "error message" is "Username exists" then create a div of class "invalidInput" show "error message" in it.
        if ($eRROR === "Username exists") {
            echo ("<div class=\"invalidInput\"> <p>");
            echo ($eRROR);
            echo ("</p> </div>");
        }
        ?>
        <div class="explanations">
            <p>
                Must contain at least 8 or more characters.
            </p>
        </div>
        <div class="input-box">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value=<?php echo $user["passwordRep"]; ?> pattern="\w{8,}$" maxlength="30" required>
            <img src="images/Eye_48px.png" onclick="PasswordShow_Hide(this,'password')" alt="show" style="height: 19px; width: 22px; margin: auto; padding:3px">
        </div>
        <div class="explanations">
            <p>
                Must contain at least 8 or more characters.
            </p>
        </div>
        <div class="input-box">
            <label for="passwordRep">Password confirmation:</label>
            <input type="password" name="passwordRep" id="passwordRep" value=<?php echo $user["passwordRep"]; ?> pattern="\w{8,}$" maxlength="30" required>
            <img src="images/Eye_48px.png" onclick="PasswordShow_Hide(this,'passwordRep')" alt="show" style="height: 19px; width: 22px; margin: auto; padding:0 3px">
        </div>
        <div class="explanations">
            <p>
                Please input your password again.
            </p>
        </div>
        <div class="input-box">
            <label for="phoneNumber">Phone Number:</label>
            <input type="tel" name="phoneNumber" id="phoneNumber" value=<?php echo $user["phoneNumber"]; ?> maxlength="12" required>
        </div>
        <?php
        ///if "error message" is "Phone Number exists" then create a div of class "invalidInput" show "error message" in it. 
        if ($eRROR === "Phone Number exists") {
            echo ("<div class=\"invalidInput\"> <p>");
            echo ($eRROR);
            echo ("</p> </div>");
        }
        ?>
        <div class="input-box">
            <label for="email">Emale:</label>
            <input type="email" name="email" id="email" value=<?php echo $user["email"]; ?> required>
        </div>
        <?php
        ///if "error message" is "Email exists" then create a div of class "invalidInput" show "error message" in it. 
        if ($eRROR === "Email exists") {
            echo ("<div class=\"invalidInput\"> <p>");
            echo ($eRROR);
            echo ("</p> </div>");
        }
        ?>
        <div class="input-box">
            <label for="birthDay">Day of Birth:</label>
            <input type="date" name="birthDay" id="birthDay" value=<?php echo $user["birthDay"]; ?> onfocus="SetDateInputMax('birthDay')" min="1945-01-01" required>
        </div>
        <button class="button" onclick="return formValidate('formSignIn')">submit</button>
    </form>
    <footer>
        <p>goodbye</p>
        <a href="http://Loremipsumdolor.sit">contact us</a>
        <p id="jsResp"></p>
    </footer>

    <?php
    ///if "error message" is not empty make input "invalid". 
    switch ($eRROR) {
            ///"error message" is "Username exists".
        case "Username exists": {
                ///make "username" input "invalid".   
                echo ("<script>InvalidInput('username', '" . $eRROR . "');</script>");
                break;
            }
            ///"error message" is "Phone Number exists". 
        case "Phone Number exists": {
                ///make "phoneNumber" input "invalid".   
                echo ("<script>InvalidInput('phoneNumber', '" . $eRROR["phoneNumber"] . "');</script>");
                break;
            }
            ///"error message" is "Email exists". 
        case "Email exists": {
                ///make "email" input "invalid".   
                echo ("<script>InvalidInput('email', '" . $eRROR["email"] . "');</script>");
                break;
            }
    }
    ?>
</body>

</html>