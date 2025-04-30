<?php

session_start();

$authenticated = false;
if(isset($_SESSION["email"])){
    $authenticated = true;
}

$first_name = "";
$last_name = "";
$email = "";
$phone = "";
$address = "";

$fname_err = "";
$Lname_err = "";
$email_err = "";
$pass_err = "";
$Cpass_err = "";


$error = false;

IF($_SERVER['REQUEST_METHOD'] == 'POST'){
    $first_name = $_POST['fname'];
    $last_name = $_POST['Lname'];
    $email = $_POST['em'];
    $password = $_POST['pass'];
    $confirmed_pass = $_POST['Cpass'];




    if(empty($first_name)){
        $fname_err = "First Name is required.";
        $error = true;
    }
    if(empty($last_name)){
        $Lname_err = "Last Name is required.";
        $error = true;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Email format invalid.";
        $error = true;
    }
    

    include "tools/db.php";
    $dbConnection = getDBConnection();

    $statement = $dbConnection->prepare("SELECT id FROM users WHERE email = ?");
    $statement->bind_param("s", $email);

    $statement->execute();


    $statement->store_result();
    if ($statement->num_rows > 0){
        $email_err = "Email already used.";
        $error = true;
    }

    $statement->close();

    if(strlen($password) < 6){
        $pass_err = "Password must be greater than 7 characters.";
        $error = true;
    }
    if($confirmed_pass != $password){
        $Cpass_err = "Passwords do not match.";
        $error = true;
    }


    if(!$error){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $created_at = date('Y-m-d H:i:s');

        $statement = $dbConnection->prepare(
            "INSERT INTO users (first_name, last_name, email, phone, address, password, created_at) ".
            "VALUES (?,?,?,?,?,?,?)"
        );

    $statement->bind_param('sssssss', $first_name,$last_name,$email,$phone,$address,$password,$created_at);

    $statement->execute();

    $insert_id = $statement->insert_id;
    $statement->close();



    $_SESSION["id"] = $insert_id;
    $_SESSION["first_name"] = $first_name;
    $_SESSION["last_name"] = $last_name;
    $_SESSION["email"] = $email;
    $_SESSION["created_at"] = $created_at;

    header("Location: home.php");
    exit();
    }
}
if($authenticated){
    header("Location: home.php");
    exit();
} else {
?>
<html>
    <title>NERV: User Registration</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
    <head>
    </head>

    <section class="loginSec">


    <div class="vidBG">
        <video autoplay muted loop id="myVideo">
            <source src="./Evangelion-UI.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <div class="overlay">
        <div class="content-wrapper">
            <div class="logo">
                <a href="https://evangelion.fandom.com/wiki/NERV">
                    <img class="NLogo" src="./NERV-Logo.png">
                </a>
            </div>

            <article class="logInfo">
                <fieldset class="mainProf">
                    <legend>
                        <h1><header class="profname">Log In/Sign Up</header></h1>
                    </legend>
                    <form method="post" id="loginF">
                        <label for="fname">First Name:</label>
                        <input type="text" id="fname" name="fname" value="<?= $first_name; ?>" required>
                        <span class="text-danger"><?= $fname_err; ?></span>

                        <label for="Lname">Last Name:</label>
                        <input type="text" id="Lname" name="Lname" value="<?= $last_name; ?>" required>
                        <span class="text-danger"><?= $Lname_err; ?></span>

                        <label for="em">Email Address:</label>
                        <input type="email" id="em" name="em" value="<?= $email; ?>" required>
                        <span class="text-danger"><?= $email_err; ?></span>

                        <label for="pass">Password:</label>
                        <input type="password" id="pass" name="pass" required>
                        <span class="text-danger"><?= $pass_err; ?></span>

                        <label for="Cpass">Confirm Password:</label>
                        <input type="password" id="Cpass" name="Cpass" required>
                        <span class="text-danger"><?= $Cpass_err; ?></span>

                        <button type="submit">Register</button>
                        <a href="./login.php">
                        <button type="button">Log In</button>
                    </a> 
                    </form>                   
                </fieldset>
            </article>
        </div>
    </div>
</section>

    </body>
</html>

<?php
}
?>
