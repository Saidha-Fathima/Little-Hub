<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

include '../db.php';

/* ADD NOTE */
if(isset($_POST['add_note'])){
    $subject = $_POST['subject'];
    $title = $_POST['title'];

    $file = $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], "../uploads/notes/".$file);

    mysqli_query($conn,"INSERT INTO notes(subject,title,file_path,uploaded_by)
    VALUES('$subject','$title','uploads/notes/$file',".$_SESSION['user_id'].")");
}

/* DELETE NOTE */
if(isset($_GET['delete'])){
    mysqli_query($conn,"DELETE FROM notes WHERE note_id=".$_GET['delete']);
}

/* FETCH NOTES */
$notes = mysqli_query($conn,"SELECT * FROM notes ORDER BY note_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>LittleHUB - Manage Notes</title>
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

/* SIDEBAR (UNCHANGED) */
.sidebar{
    width:230px;
    height:100vh;
    background:linear-gradient(180deg,#667eea,#764ba2);
    color:#fff;
    padding:15px;
    position:fixed;
    top:0;
    left:0;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
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

/* HEADER (UNCHANGED STYLE) */
.header{
    background:linear-gradient(135deg,#667eea,#764ba2);
    padding:15px 20px;
    border-radius:12px;
    margin-bottom:20px;
    color:#fff;
    box-shadow:0 6px 18px rgba(0,0,0,0.15);
}

/* FORM CARD */
.form-card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
    margin-bottom:20px;
}

.form-card h3{
    margin-bottom:10px;
    color:#667eea;
}

.form-card input{
    width:100%;
    padding:10px;
    margin:8px 0;
    border:1px solid #ccc;
    border-radius:6px;
}

/* FILE INPUT STYLE */
input[type="file"]{
    width:100%;
    padding:8px;
    border:1px solid #ccc;
    border-radius:6px;
    background:#f9f9f9;
    cursor:pointer;
}

input[type="file"]::file-selector-button{
    border:none;
    padding:8px 12px;
    border-radius:6px;
    background:#667eea;
    color:#fff;
    cursor:pointer;
    margin-right:10px;
    transition:0.3s;
}

input[type="file"]::file-selector-button:hover{
    background:#5a67d8;
}

/* BUTTON */
.add-btn{
    width:100%;
    padding:10px;
    border:none;
    border-radius:6px;
    background:#667eea;
    color:#fff;
    cursor:pointer;
}

.add-btn:hover{
    background:#5a67d8;
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

/* ICON */
.icon-btn{
    border:none;
    background:none;
    cursor:pointer;
    font-size:16px;
}

.delete-icon{
    color:#ff4d4d;
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
}

</style>
</head>

<body>

<div class="wrapper">

<!-- SIDEBAR (UNCHANGED) -->
<div class="sidebar">

    <div>
        <h2><i class="fas fa-user-shield"></i> LittleHUB Admin</h2>

        <a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
        <a href="manage_books.php"><i class="fas fa-book"></i> Manage Books</a>
        <a href="manage_notes.php" class="active"><i class="fas fa-sticky-note"></i> Manage Notes</a>
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

<!-- HEADER (UNCHANGED) -->
<div class="header">
    <h2><i class="fas fa-sticky-note"></i> Manage Notes</h2>
</div>

<!-- FORM -->
<div class="form-card">

<h3>Add New Note</h3>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="subject" placeholder="Subject" required>
<input type="text" name="title" placeholder="Title" required>

<input type="file" name="file" required>

<button name="add_note" class="add-btn">Add Note</button>

</form>

</div>

<!-- TABLE -->
<div class="table-card">

<table>
<tr>
<th>ID</th>
<th>Subject</th>
<th>Title</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($notes)): ?>
<tr>
<td><?= $row['note_id'] ?></td>
<td><?= $row['subject'] ?></td>
<td><?= $row['title'] ?></td>

<td>
<a href="?delete=<?= $row['note_id'] ?>"
onclick="return confirm('Delete this note?')"
class="icon-btn delete-icon">
<i class="fas fa-trash"></i>
</a>
</td>

</tr>
<?php endwhile; ?>

</table>

</div>

</div>

</div>

</body>
</html>