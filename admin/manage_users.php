<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

include '../db.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>LittleHUB - Manage Users</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>

/* RESET */
* {
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body {
    font-family:Segoe UI, sans-serif;
    background:#f4f6fb;
}

/* WRAPPER */
.wrapper {
    display:flex;
}

/* SIDEBAR */
.sidebar {
    width:230px;
    height:100vh;
    background: linear-gradient(180deg, #667eea, #764ba2);
    color:#fff;
    position:fixed;
    top:0;
    left:0;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    padding:15px;
    box-shadow: 4px 0 15px rgba(0,0,0,0.15);
}

.sidebar h2 {
    font-size:16px;
    margin-bottom:15px;
    color:#fff;
}

.sidebar a {
    display:block;
    color:#f1f1f1;
    text-decoration:none;
    padding:10px;
    border-radius:8px;
    margin-bottom:6px;
    font-size:14px;
    transition:0.3s;
}

.sidebar a.active {
    background: #ffffff;
    color: #667eea;
    font-weight: 700;
    transform: translateX(6px);
    border-left: 6px solid #ffffff;
    box-shadow: 0 4px 12px rgba(0, 245, 255, 0.25);
}

.sidebar a:hover {
    background: rgba(255,255,255,0.2);
    transform: translateX(5px);
}

/* MAIN */
.main {
    margin-left:230px;
    padding:20px;
    width:calc(100% - 230px);
}

/* HEADER */
.header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    padding:15px 20px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 6px 18px rgba(0,0,0,0.15);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.header h2 {
    margin:0;
    font-size:18px;
    font-weight:600;
}

.header i {
    margin-right:8px;
    color:#fff;
}

/* LOGOUT */
.logout button {
    width:100%;
    padding:10px;
    border:none;
    border-radius:8px;
    background:#ffffff;
    color:#667eea;
    font-weight:600;
    cursor:pointer;
    transition:0.25s ease;
}

.logout button:hover {
    background:#667eea;
    color:#ffffff;
}

</style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div>
            <h2><i class="fas fa-user-shield"></i> LittleHUB Admin</h2>

            <a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="manage_users.php" class="active"><i class="fas fa-users"></i> Manage Users</a>
            <a href="manage_books.php"><i class="fas fa-book"></i> Manage Books</a>
            <a href="manage_notes.php"><i class="fas fa-sticky-note"></i> Manage Notes</a>
            <a href="activity_logs.php"><i class="fas fa-chart-line"></i> Activity Log</a>
        </div>

        <div class="logout">
            <button onclick="location.href='../logout.php'">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>

    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- HEADER -->
        <div class="header">
            <h2><i class="fas fa-users"></i> Manage Users</h2>
        </div>

    </div>

</div>

</body>
</html>