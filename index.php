<?php

session_start();

$authenticated = false;
if (isset($_SESSION["email"])) {
    $authenticated = true;
}

$first_name = "";
$last_name = "";
$username = "";
$email = "";
$phone = "";
$address = "";

$fname_err = "";
$Lname_err = "";
$user_err = "";
$email_err = "";
$pass_err = "";
$Cpass_err = "";

$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['fname'] ?? '';
    $last_name = $_POST['Lname'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['em'] ?? '';
    $password = $_POST['pass'] ?? '';
    $confirmed_pass = $_POST['Cpass'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    if (empty($first_name)) {
        $fname_err = "First Name is required.";
        $error = true;
    }
    if (empty($last_name)) {
        $Lname_err = "Last Name is required.";
        $error = true;
    }
    if (empty($username)) {
        $user_err = "Username is required.";
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
    if ($statement->num_rows > 0) {
        $email_err = "Email already used.";
        $error = true;
    }
    $statement->close();

    if (strlen($password) < 6) {
        $pass_err = "Password must be at least 6 characters.";
        $error = true;
    }
    if ($confirmed_pass != $password) {
        $Cpass_err = "Passwords do not match.";
        $error = true;
    }

    if (!$error) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $created_at = date('Y-m-d H:i:s');

        $statement = $dbConnection->prepare(
            "INSERT INTO users (first_name, last_name, username, email, phone, address, password, created_at) " .
            "VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $statement->bind_param('ssssssss', $first_name, $last_name, $username, $email, $phone, $address, $password, $created_at);

        $statement->execute();

        $insert_id = $statement->insert_id;
        $statement->close();

        $_SESSION["id"] = $insert_id;
        $_SESSION["first_name"] = $first_name;
        $_SESSION["last_name"] = $last_name;
        $_SESSION["email"] = $email;
        $_SESSION["created_at"] = $created_at;

        header("Location: login.php");
        exit();
    }
}

if ($authenticated) {
    header("Location: home.php");
    exit();
} else {
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Registration</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    form {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
    }

    button {
      padding: 12px;
      width: 100%;
      background-color: #007bff;
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <form action="register.php" method="POST">
    <h2>Create an Account</h2>
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
  </form>
</body>
</html>
<?php } ?>
