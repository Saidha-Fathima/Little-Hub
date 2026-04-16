<?php
session_start();
include 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); // hash using md5
    $role = 'user';

    // Check if email exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        $message = "Email already registered!";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO users (name,email,password,role) VALUES ('$name','$email','$password','$role')");
        if($insert){
            $message = "Registration successful! <a href='login.php'>Login Now</a>";
        } else {
            $message = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - LittleHUB</title>
<link rel="stylesheet" href="login_register.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <div class="header-logo">
        <i class="fas fa-book-open"></i>
        <span>LittleHUB</span>
    </div>
<div class="form-container">
    <h2>Register</h2>
    <?php if($message != "") { echo "<p class='message'>$message</p>"; } ?>
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login Here</a></p>
</div>
</body>
</html>