<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard - LittleHUB</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
.dashboard-grid {
    max-width:1000px;
    margin:auto;
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(230px,1fr));
    gap:20px;
    margin-top:40px;
}

.feature-card {
    background:#fff;
    border-radius:12px;
    padding:20px;
    text-align:center;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    cursor:pointer;
    transition:0.3s;
}

.feature-card:hover {
    transform:translateY(-6px);
    box-shadow:0 14px 28px rgba(0,0,0,0.12);
}

.feature-icon {
    font-size:2.5rem;
    color:#667eea;
    margin-bottom:10px;
}

.hero-title {
    text-align:center;
    margin-top:40px;
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
            <a href="dashboard.php" class="nav-link active">Dashboard</a>
            <a href="books.php" class="nav-link">Books</a>
            <a href="notes.php" class="nav-link">Notes</a>
            <a href="store.php" class="nav-link">Store</a>
            <a href="aboutus.php" class="nav-link">About Us</a>
        </div>

        <div class="nav-actions">
            <button class="btn btn-primary" onclick="location.href='logout.php'">Logout</button>
        </div>
    </div>
</nav>

<main>
<h1 class="hero-title">Welcome, <u><?php echo $user_name; ?></u></h1>

<div class="dashboard-grid">
    <div class="feature-card" onclick="location.href='books.php'">
        <div class="feature-icon"><i class="fas fa-book-reader"></i></div>
        <h3>Books</h3>
        <p>Explore and read books</p>
    </div>

    <div class="feature-card" onclick="location.href='notes.php'">
        <div class="feature-icon"><i class="fas fa-file-alt"></i></div>
        <h3>Notes</h3>
        <p>Download study notes</p>
    </div>

    <div class="feature-card" onclick="location.href='store.php'">
        <div class="feature-icon"><i class="fas fa-store"></i></div>
        <h3>Store</h3>
        <p>Purchase books</p>
    </div>
</div>
</main>

</body>
</html>