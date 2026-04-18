<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

include '../db.php';

/* FILTER VALUES */
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$action  = isset($_GET['action']) ? trim($_GET['action']) : '';
$from    = isset($_GET['from']) ? $_GET['from'] : '';
$to      = isset($_GET['to']) ? $_GET['to'] : '';

/* USERS */
$users = mysqli_query($conn,"SELECT user_id,name FROM users");

/* QUERY */
$sql = "
SELECT a.*, u.name 
FROM activity_log a
JOIN users u ON a.user_id = u.user_id
WHERE 1=1
";

if($user_id > 0){
    $sql .= " AND a.user_id=$user_id";
}

if($action != ''){
    $sql .= " AND a.action LIKE '%$action%'";
}

if($from != '' && $to != ''){
    $sql .= " AND DATE(a.created_at) BETWEEN '$from' AND '$to'";
}

$sql .= " ORDER BY a.created_at DESC";

$logs = mysqli_query($conn,$sql);
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
    box-shadow:4px 0 15px rgba(0,0,0,0.15);
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
}

.sidebar a.active{
    background:#fff;
    color:#667eea;
    font-weight:700;
    transform:translateX(5px);
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

/* FILTER */
.filter-card{
    background:#fff;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.filter-grid{
    display:grid;
    grid-template-columns:repeat(5, 1fr);
    gap:10px;
}

input,select{
    padding:10px;
    border:1px solid #ccc;
    border-radius:6px;
    width:100%;
}

button{
    background:#667eea;
    color:#fff;
    border:none;
    padding:10px;
    border-radius:6px;
    cursor:pointer;
}

/* TABLE */
.table-card{
    background:#fff;
    padding:15px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:600px;
}

th,td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #eee;
    white-space:nowrap;
}

th{
    background:#667eea;
    color:#fff;
}

.badge{
    background:#eef2ff;
    padding:5px 10px;
    border-radius:6px;
}

/* ================= RESPONSIVE ================= */

@media(max-width: 992px){
    .filter-grid{
        grid-template-columns:1fr 1fr;
    }
}

@media(max-width: 768px){

    .sidebar{
        position:relative;
        width:100%;
        height:auto;
        flex-direction:row;
        overflow-x:auto;
    }

    .main{
        margin-left:0;
        width:100%;
    }

    .filter-grid{
        grid-template-columns:1fr;
    }

    table{
        min-width:650px;
    }
}

@media(max-width: 480px){
    .header h2{
        font-size:16px;
    }

    .sidebar a{
        font-size:12px;
    }
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
        <a href="manage_users.php"><i class="fas fa-users"></i> Users</a>
        <a href="manage_books.php"><i class="fas fa-book"></i> Books</a>
        <a href="manage_notes.php"><i class="fas fa-sticky-note"></i> Notes</a>
        <a href="activity_logs.php" class="active"><i class="fas fa-chart-line"></i> Logs</a>
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

<!-- FILTER -->
<div class="filter-card">

<form method="GET" class="filter-grid">

<!-- USER -->
<select name="user_id">
<option value="0">All Users</option>
<?php while($u=mysqli_fetch_assoc($users)){ ?>
<option value="<?php echo $u['user_id']; ?>"
<?php if($user_id==$u['user_id']) echo "selected"; ?>>
<?php echo $u['name']; ?>
</option>
<?php } ?>
</select>

<!-- ACTION -->
<input type="text" name="action" placeholder="Search activity"
value="<?php echo $action; ?>">

<!-- FROM -->
<input type="date" name="from" value="<?php echo $from; ?>">

<!-- TO -->
<input type="date" name="to" value="<?php echo $to; ?>">

<button type="submit">Filter</button>

</form>

</div>

<!-- TABLE -->
<div class="table-card">

<table>
<tr>
<th>User</th>
<th>Action</th>
<th>Date</th>
</tr>

<?php while($row=mysqli_fetch_assoc($logs)){ ?>
<tr>
<td><?php echo htmlspecialchars($row['name']); ?></td>
<td><span class="badge"><?php echo htmlspecialchars($row['action']); ?></span></td>
<td><?php echo $row['created_at']; ?></td>
</tr>
<?php } ?>

</table>

</div>

</div>

</div>

</body>
</html>