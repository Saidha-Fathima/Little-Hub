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
<title>LittleHUB - Activity Logs</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Segoe UI, sans-serif;
    background:#f4f6fb;
}

/* WRAPPER */
.wrapper{
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:230px;
    height:100vh;
    background:linear-gradient(180deg,#667eea,#764ba2);
    color:#fff;
    position:fixed;
    top:0;
    left:0;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    padding:15px;
}

.sidebar h2{
    font-size:16px;
    margin-bottom:15px;
}

.sidebar a{
    display:block;
    color:#f1f1f1;
    text-decoration:none;
    padding:10px;
    border-radius:8px;
    margin-bottom:6px;
    font-size:14px;
    transition:0.3s;
}

.sidebar a.active{
    background:#fff;
    color:#667eea;
    font-weight:700;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.2);
}

/* MAIN */
.main{
    margin-left:230px;
    padding:20px;
    width:calc(100% - 230px);
}

/* HEADER */
.header{
    background:linear-gradient(135deg,#667eea,#764ba2);
    padding:15px 20px;
    border-radius:12px;
    margin-bottom:20px;
    color:#fff;
    box-shadow:0 6px 18px rgba(0,0,0,0.15);
}

/* TABLE CARD */
.table-card{
    background:#fff;
    padding:15px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #eee;
}

th{
    background:#667eea;
    color:#fff;
}

tr:hover{
    background:#f9f9f9;
}

/* BADGE STYLE */
.badge{
    display:inline-block;
    padding:5px 10px;
    border-radius:6px;
    background:#eef2ff;
    color:#333;
    font-size:13px;
}

/* LOGOUT */
.logout button{
    width:100%;
    padding:10px;
    border:none;
    border-radius:8px;
    background:#fff;
    color:#667eea;
    font-weight:600;
    cursor:pointer;
    transition:0.25s;
}

.logout button:hover{
    background:#667eea;
    color:#fff;
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
            <a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
            <a href="manage_books.php"><i class="fas fa-book"></i> Manage Books</a>
            <a href="manage_notes.php"><i class="fas fa-sticky-note"></i> Manage Notes</a>
            <a href="activity_logs.php" class="active"><i class="fas fa-chart-line"></i> Activity Log</a>
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
            <h2><i class="fas fa-chart-line"></i> Activity Logs</h2>
        </div>

        <!-- TABLE -->
        <div class="table-card">

            <table>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Date</th>
                </tr>

                <?php
                include '../db.php';

                $logs = mysqli_query($conn,"
                SELECT a.*, u.name 
                FROM activity_log a
                JOIN users u ON a.user_id = u.user_id
                ORDER BY a.created_at DESC
                ");

                while($row=mysqli_fetch_assoc($logs)):
                ?>

                <tr>
                    <td><?= $row['name'] ?></td>
                    <td><span class="badge"><?= $row['action'] ?></span></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>

                <?php endwhile; ?>

            </table>

        </div>

    </div>

</div>

</body>
</html>