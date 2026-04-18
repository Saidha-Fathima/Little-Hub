<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About - LittleHUB</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>

/* BODY */
body {
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
}

/* HERO */
.hero {
    text-align:center;
    color:#fff;
    padding:70px 15px 10px;
}

.hero h1 {
    margin:0;
    font-size:32px;
}

/* CONTAINER */
.container {
    max-width:850px;
    margin:20px auto;
    padding:10px;
}

/* CARD */
.card {
    background:#fff;
    border-radius:10px;
    padding:20px;
    margin-bottom:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

/* CONTACT ITEMS */
.contact-item {
    margin:10px 0;
    font-size:15px;
}

.contact-item i {
    color:#667eea;
    margin-right:8px;
}

/* ABOUT */
.about-project {
    background:#fff;
    border-radius:10px;
    padding:20px;
    margin-bottom:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.about-project h3 {
    margin-bottom:10px;
    color:#333;
}

.about-project p {
    font-size:14px;
    color:#555;
    line-height:1.6;
}

/* FOOTER */
.footer {
    text-align:center;
    color:#fff;
    padding:15px;
    margin-top:20px;
    font-size:13px;
    opacity:0.9;
}

</style>
</head>

<body>

<!-- NAVBAR (UNCHANGED) -->
<nav class="navbar">
    <div class="nav-container">
        <div class="nav-brand">
            <i class="fas fa-book-open"></i> LittleHUB
        </div>

        <div class="nav-menu">
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="books.php" class="nav-link">Books</a>
            <a href="notes.php" class="nav-link">Notes</a>
            <a href="store.php" class="nav-link">Store</a>
            <a href="aboutus.php" class="nav-link active">About us</a>
        </div>

        <div class="nav-actions">
            <button class="btn btn-primary" onclick="location.href='logout.php'">
                Logout
            </button>
        </div>
    </div>
</nav>

<!-- HERO -->
<div class="hero">
    <h1>Thanks for Visiting LittleHUB</h1>
</div>

<!-- CONTENT -->
<div class="container">

    <!-- ABOUT PROJECT -->
    <div class="about-project">
        <h3>About This Project</h3>

        <p><strong>LittleHUB</strong> is a student learning platform designed to provide books, notes, and educational resources in one place.</p>

        <p>
            This system includes book management, notes sharing, online store, and admin dashboard.
            Built using <strong>PHP, MySQL, HTML, CSS, JavaScript</strong>.
        </p>

        <p>
            The goal is to simplify digital learning and make resources easily accessible anytime.
        </p>
    </div>

    <!-- CONTACT INFO -->
    <div class="card">
        <h3>Contact Details</h3>

        <div class="contact-item">
            <i class="fas fa-user"></i> Saidha Fathima
        </div>

        <div class="contact-item">
            <i class="fas fa-envelope"></i> Admin@litHub.com
        </div>

        <div class="contact-item">
            <i class="fas fa-phone"></i> +91 98765 43210
        </div>
    </div>

</div>

<!-- FOOTER -->
<div class="footer">
    © <?php echo date("Y"); ?> LittleHUB. All Rights Reserved.
</div>

</body>
</html>