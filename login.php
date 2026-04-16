<?php
session_start();
include 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        if($user['password'] === md5($password)){
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // Redirect based on role
            if($user['role'] === 'admin'){
                header("Location: admin/admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $message = "Incorrect password!";
        }
    } else {
        $message = "No account found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - LittleHUB</title>
<link rel="stylesheet" href="login_register.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <div class="header-logo">
        <i class="fas fa-book-open"></i>
        <span>LittleHUB</span>
    </div>
    <div class="form-container">
        <h2>Login</h2>
        <?php if($message != "") { echo "<p class='message'>$message</p>"; } ?>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register Here</a></p>
    </div>
</body>
</html>