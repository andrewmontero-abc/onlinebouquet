<?php

session_start();

if(isset($_SESSION["email"])){
    header("location: ./home.php");
    exit;
}


$email = "";
$error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = trim($_POST['em-auth']);
    $password = trim($_POST['pass-auth']);

    if(empty($email) || empty($password)){
        $error = "Email and/or Password is required.";
    } else{
        include "tools/db.php";
        $dbConnection = getDBConnection();
     
        $statement = $dbConnection->prepare(
            "SELECT id, first_name, last_name, phone, password, created_at FROM users WHERE email = ?"
        );

        $statement->bind_param('s',$email);
        $statement->execute();


        $statement->bind_result($id, $first_name, $last_name, $phone, $stored_password, $created_at);




        $entered = 'TestPass444';
        $hash = '$2y$10$YHlni1Ev/XuE0H6TVCWiq.bL/nn1l7brL5sxCP2HYZZE3Re61FJ12';
        

        if($statement->fetch()){

            if(password_verify($password,$stored_password)){
                echo "<script>console.log('DEBUG: Password MATCHED');</script>";
                $_SESSION["id"] = $id;
                $_SESSION["first_name"] = $first_name;
                $_SESSION["last_name"] = $last_name;
                $_SESSION["email"] = $email;
                $_SESSION["phone"] = $phone;
                $_SESSION["created_at"] = $created_at;
                
                header("location: ./home.php");
                exit;
            }
        }

        $statement->close();

        $error = "Email or Password Invalid";
    }
}

?>

    <title>NERV: User Registration</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
<body>
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

                    <?php
                     if(!empty($error)) { 
                         var_dump($stored_password);
                    } 
                    ?>


                    <form method="post" id="loginF">
                        <label for="em-auth">Email Address:</label>
                        <input type="email" id="em-auth" name="em-auth" value="<?= $email; ?>" required>

                        <label for="pass-auth">Password:</label>
                        <input type="password" id="pass-auth" name="pass-auth" required>

                        <button type="submit">Log In</button>
                        <a href="./index.php">
                        <button type="button">Return to Registration</button>
                    </a> 
                    </form>                   
                </fieldset>
            </article>
        </div>
    </div>
</section>
</body>
