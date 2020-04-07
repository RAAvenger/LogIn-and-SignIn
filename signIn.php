<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="sign in style.css">
    <script src="logInScript.js"></script>
    <title>Sign in</title>
</head>
<body class="contaner">
<?php
$done = false;
$user['username'] = $user['password'] = $user['passwordRep'] = $user['firstName'] = $user['lastName'] = $user['phoneNumber'] = $user['email'] = $user['birthDay'] = '""';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once('config.php');
    include_once('database.php');

    echo "<script>InsertStyle();</script>";
    $user['username'] = test_input($_POST["username"]);
    $user['password'] = password_hash(test_input($_POST["password"]), PASSWORD_ARGON2I);
    $user['passwordRep'] = $_POST["passwordRep"];
    $user['firstName'] = test_input($_POST["firstName"]);
    $user['lastName'] = test_input($_POST["lastName"]);
    $user['phoneNumber'] = test_input($_POST["phoneNumber"]);
    $user['email'] = test_input($_POST["email"]);
    $user['birthDay'] = test_input($_POST["birthDay"]);
}
?>
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
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
            laborum.
        </p>
    </div>
    <div class="input-box">
        <p>First Name:</p>
        <input type="text" name="firstName" id="firstName" value=<?php echo $user["firstName"]; ?> pattern="[A-Za-z]+"
               maxlength="40" required>
    </div>
    <div class="explanations">
        <p>
            Must contain only uppercase or lowercase letter.
        </p>
    </div>
    <div class="input-box">
        <p>Last Name:</p>
        <input type="text" name="lastName" id="lastName" value=<?php echo $user["lastName"]; ?> pattern="[A-Za-z]+"
               maxlength="60" required>
    </div>
    <div class="explanations">
        <p>
            Must contain only uppercase or lowercase letter.
        </p>
    </div>
    <div class="input-box">
        <p>Usermame:</p>
        <input type="username" name="username" id="username" value=<?php echo $user["username"]; ?> pattern="\w{5,}$"
               maxlength="25" required>
    </div>
    <div class="explanations">
        <p>
            Must contain at least 8 or more characters.
        </p>
    </div>
    <div class="input-box">
        <p>Password:</p>
        <input type="password" name="password" id="password" value=<?php echo $user["passwordRep"]; ?> pattern="\w{8,}$"
               maxlength="30" required>
        <img src="images/Eye_48px.png" onclick="PasswordShow_Hide(this,'password')" alt="show"
             style="height: 19px; width: 22px; margin: auto; padding:3px">
    </div>
    <div class="explanations">
        <p>
            Must contain at least 8 or more characters.
        </p>
    </div>
    <div class="input-box">
        <p>Password confirmation:</p>
        <input type="password" name="passwordRep" id="passwordRep"
               value=<?php echo $user["passwordRep"]; ?> pattern="\w{8,}$" maxlength="30" required>
        <img src="images/Eye_48px.png" onclick="PasswordShow_Hide(this,'passwordRep')" alt="show"
             style="height: 19px; width: 22px; margin: auto; padding:0 3px">
    </div>
    <div class="explanations">
        <p>
            Please input your password again.
        </p>
    </div>
    <div class="input-box">
        <p>Phone Number:</p>
        <input type="tel" name="phoneNumber" id="phoneNumber" value=<?php echo $user["phoneNumber"]; ?> maxlength="12"
               required>
    </div>
    <div class="input-box">
        <p>Emale:</p>
        <input type="email" name="email" id="email" value=<?php echo $user["email"]; ?> required>
    </div>
    <div class="input-box">
        <p>Day of Birth:</p>
        <input type="date" name="birthDay" id="birthDay"
               value=<?php echo $user["birthDay"]; ?> onfocus="SetDateInputMax('birthDay')" min="1945-01-01"
               required>
    </div>
    <button class="button" onclick="return formValidate('formSignIn')">submit</button>
</form>
<footer>
    <p>goodbye</p>
    <a href="http://Loremipsumdolor.sit">contact us</a>
    <p id="jsResp"></p>
</footer>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = ConnectionOpen($databaseServer, $databaseUsername, $databasePassword);
    switch (NewUserAlreadyExists($conn, $user['username'], $user['phoneNumber'], $user['email'])) {
        case 1:
        {
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
            break;
        }
        case -1:
        {
            echo("error");
            break;
        }
        case -2:
        {
            echo("<script>InvalidInput('username', 'Username exists');f();</script>");
            break;
        }
        case -3:
        {
            echo("<script> InvalidInput('phoneNumber', 'Phone Number exists');</script>");
            break;
        }
        case -4:
        {
            echo("<script> InvalidInput('email', 'Email exists');</script>");
            break;
        }
    }
    ConnectionClose($conn);
}
?>
</body>
</html>
