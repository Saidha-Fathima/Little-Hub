<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

include '../db.php';

/* ========= ADD NOTE ========= */
if(isset($_POST['add_note'])){

    $subject = trim($_POST['subject']);
    $title = trim($_POST['title']);

    $fileName = time() . "_" . basename($_FILES['file']['name']);
    $filePath = "uploads/notes/".$fileName;

    if(!file_exists("../uploads/notes")){
        mkdir("../uploads/notes",0755,true);
    }

    move_uploaded_file($_FILES['file']['tmp_name'], "../".$filePath);

    $stmt = $conn->prepare("INSERT INTO notes(subject,title,file_path,uploaded_by) VALUES(?,?,?,?)");
    $stmt->bind_param("sssi",$subject,$title,$filePath,$_SESSION['user_id']);
    $stmt->execute();

    header("Location: manage_notes.php");
    exit();
}

/* ========= FETCH EDIT ========= */
$editData = array();

if(isset($_GET['edit'])){
    $id = intval($_GET['edit']);
    $res = mysqli_query($conn,"SELECT * FROM notes WHERE note_id=$id");
    if($res){
        $editData = mysqli_fetch_assoc($res);
    }
}

/* ========= UPDATE ========= */
if(isset($_POST['update_note'])){

    $id = intval($_POST['note_id']);
    $subject = trim($_POST['subject']);
    $title = trim($_POST['title']);

    $stmt = $conn->prepare("UPDATE notes SET subject=?, title=? WHERE note_id=?");
    $stmt->bind_param("ssi",$subject,$title,$id);
    $stmt->execute();

    header("Location: manage_notes.php");
    exit();
}

/* ========= DELETE ========= */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM notes WHERE note_id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();

    header("Location: manage_notes.php");
    exit();
}

/* ========= FETCH ALL ========= */
$notes = mysqli_query($conn,"SELECT * FROM notes ORDER BY note_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>LittleHUB - Manage Notes</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>

/* RESET */
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:Segoe UI, sans-serif;
    background:#f4f6fb;
}

.wrapper{display:flex;}

/* SIDEBAR */
.sidebar{
    width:230px;
    height:100vh;
    background:linear-gradient(180deg,#667eea,#764ba2);
    color:#fff;
    position:fixed;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    padding:15px;
    box-shadow:4px 0 15px rgba(0,0,0,0.15);
}

.sidebar h2{font-size:16px;margin-bottom:15px;}

.sidebar a{
    display:block;
    color:#f1f1f1;
    text-decoration:none;
    padding:10px;
    border-radius:8px;
    margin-bottom:6px;
    transition:0.3s;
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

/* FORM */
.form-card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.form-card input{
    width:100%;
    padding:10px;
    margin:8px 0;
    border:1px solid #ccc;
    border-radius:6px;
}

/* FILE */
input[type="file"]::file-selector-button{
    border:none;
    padding:8px 12px;
    background:#667eea;
    color:#fff;
    border-radius:6px;
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

/* TABLE */
.table-card{
    background:#fff;
    padding:15px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
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

/* ICONS */
.edit-icon{
    color:#3498db; /* BLUE */
    margin-right:10px;
}

.delete-icon{
    color:#e74c3c;
}

.icon-btn{
    font-size:16px;
    text-decoration:none;
}

/* IMAGE PREVIEW (optional future use) */

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

<div class="header">
<h2>
<i class="fas fa-sticky-note"></i>
<?php echo isset($editData['note_id']) ? "Edit Note" : "Manage Notes"; ?>
</h2>
</div>

<!-- FORM -->
<div class="form-card">

<form method="POST" enctype="multipart/form-data">

<input type="hidden" name="note_id"
value="<?php echo isset($editData['note_id']) ? $editData['note_id'] : ''; ?>">

<input type="text" name="subject" placeholder="Subject" required
value="<?php echo isset($editData['subject']) ? $editData['subject'] : ''; ?>">

<input type="text" name="title" placeholder="Title" required
value="<?php echo isset($editData['title']) ? $editData['title'] : ''; ?>">

<?php if(!isset($editData['note_id'])){ ?>
<input type="file" name="file" required>
<?php } ?>

<button class="add-btn"
name="<?php echo isset($editData['note_id']) ? 'update_note' : 'add_note'; ?>">
<?php echo isset($editData['note_id']) ? 'Update Note' : 'Add Note'; ?>
</button>

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

<?php while($row=mysqli_fetch_assoc($notes)){ ?>
<tr>
<td><?php echo $row['note_id']; ?></td>
<td><?php echo htmlspecialchars($row['subject']); ?></td>
<td><?php echo htmlspecialchars($row['title']); ?></td>

<td>
<a href="?edit=<?php echo $row['note_id']; ?>" class="icon-btn edit-icon">
<i class="fas fa-edit"></i>
</a>

<a href="?delete=<?php echo $row['note_id']; ?>"
onclick="return confirm('Delete this note?')"
class="icon-btn delete-icon">
<i class="fas fa-trash"></i>
</a>
</td>

</tr>
<?php } ?>

</table>

</div>

</div>
</div>

</body>
</html>