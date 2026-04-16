<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

include '../db.php';

/* SAFE COUNTS */
function getCount($conn, $table) {
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM $table");
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

$user_count = getCount($conn, "users");
$book_count = getCount($conn, "books");
$note_count = getCount($conn, "notes");
$online_book_count = getCount($conn, "online_books");
?>

<!DOCTYPE html>
<html>
<head>
<title>LittleHUB Admin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>

/* RESET (IMPORTANT) */
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

/* TITLE */
.sidebar h2 {
    font-size:16px;
    margin-bottom:15px;
    color:#fff;
}

/* LINKS */
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

/* HOVER EFFECT */
.sidebar a:hover {
    background: rgba(255,255,255,0.2);
    color:#fff;
    transform: translateX(5px);
}

.sidebar a.active {
    background: #ffffff;
    color: #667eea;
    font-weight: 700;
    transform: translateX(6px);
    border-left: 6px solid #ffffff;
    box-shadow: 0 4px 12px rgba(0, 245, 255, 0.25);
}

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

/* HOVER */
.logout button:hover {
    background:#667eea;
    color:#ffffff;
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

/* TITLE INSIDE HEADER */
.header h2 {
    margin:0;
    font-size:18px;
    font-weight:600;
    letter-spacing:0.5px;
}

/* OPTIONAL ICON STYLE */
.header i {
    margin-right:8px;
    color:#fff;
}

/* GRID */
.grid {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:15px;
}

/* CARD */
.card {
    background:#fff;
    padding:20px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover {
    transform:translateY(-5px);
}

.card i {
    font-size:28px;
    color:#667eea;
    margin-bottom:8px;
}

</style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div>
            <h2><i class="fas fa-user-shield"></i> LittleHUB Admin</h2>

            <a href="admin_dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
            <a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
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

        <div class="header">
            <h2><i class="fas fa-book-open"></i> LittleHUB Admin Dashboard</h2>
        </div>

        <div class="grid">

            <div class="card">
                <i class="fas fa-users"></i>
                <h3><?php echo $user_count; ?></h3>
                <p>Total Users</p>
            </div>

            <div class="card">
                <i class="fas fa-book"></i>
                <h3><?php echo $book_count; ?></h3>
                <p>Total Books</p>
            </div>

            <div class="card">
                <i class="fas fa-file-alt"></i>
                <h3><?php echo $note_count; ?></h3>
                <p>Total Notes</p>
            </div>

            <div class="card">
                <i class="fas fa-book-reader"></i>
                <h3><?php echo $online_book_count; ?></h3>
                <p>Online Books</p>
            </div>

        </div>

    </div>

</div>

</body>
</html>

<?php mysqli_close($conn); ?>