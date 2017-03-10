<?php
ob_start();
session_start();
if( isset($_SESSION['user'])!="" ){
    header("Location: home.php");
}

$link = mysqli_connect("127.0.0.1", "root", "", "db_1");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

echo "DB Connected";

if ( isset($_POST['signup']) ) {

    // clean user inputs to prevent sql injections
    $name = trim($_POST['username']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    $error = false;

    // basic name validation
    if (empty($name)) {
        $error = true;
        $nameError = "Please enter your full name.";
    } else if (strlen($name) < 3) {
        $error = true;
        $nameError = "Name must have atleat 3 characters.";
    } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
        $error = true;
        $nameError = "Name must contain alphabets and space.";
    }

    //basic email validation
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // check email exist or not
        $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
        $result = mysqli_query($link,$query);
        $count = mysqli_num_rows($result);
        if($count!=0){
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }
    // password validation
    if (empty($pass)){
        $error = true;
        $passError = "Please enter password.";
    } else if(strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have atleast 6 characters.";
    }

    // password encrypt using SHA256();
    $password = hash('sha256', $pass);

    // if there's no error, continue to signup
    if( !$error ) {

        $query = "INSERT INTO users(userName,userEmail,userPass) VALUES('$name','$email','$password')";
        $res = mysqli_query($link,$query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            unset($name);
            unset($email);
            unset($pass);
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
        }

    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/register.css">
</head>
<body>
<div>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html">✌ GAMERS GUIDE ✌</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.html">Home</a></li>
            </ul>
        </div>
    </nav>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post">
    <div class="input-groups">
        <div class="input-group">
        <input id="username" type="text" class="form-control" name="username" placeholder="Username">
        <span class="input-group-addon"><i class="glyphicon glyphicon-bishop"></i></span>
        </div>
        <div class="input-group">
            <input id="email" type="text" class="form-control" name="email" placeholder="Email">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        </div>
        <div class="input-group">
            <input id="password" type="password" class="form-control" name="password" placeholder="Password">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        </div>
        <div class="input-group">
            <label>
                <input type="checkbox" name="accept">
            </label>I Accept <a href="#">Terms and Conditions</a>
        </div>
        <div class="input-group">
        <button type="submit" class="btn btn-success" name="signup">Sign Up</button>
        </div>
    </div>
</form>
</div>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
</body>
</html>