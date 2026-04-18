<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

include '../db.php';

/* DELETE USER */
if(isset($_GET['delete'])){
    $delete_id = intval($_GET['delete']);

    if($delete_id != $_SESSION['user_id']){
        mysqli_query($conn, "DELETE FROM users WHERE user_id=$delete_id");
        header("Location: manage_users.php");
        exit();
    }
}

/* UPDATE USER */
if(isset($_POST['update_user'])){
    $id = intval($_POST['user_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = $_POST['role'];

    mysqli_query($conn, "UPDATE users SET name='$name', email='$email', role='$role' WHERE user_id=$id");
    header("Location: manage_users.php");
    exit();
}

/* FETCH USERS */
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>LittleHUB - Manage Users</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>

/* RESET */
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:Segoe UI, sans-serif;
    background:#f4f6fb;
}

/* WRAPPER */
.wrapper{display:flex;}

/* SIDEBAR (SAME AS YOUR DESIGN) */
.sidebar{
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
    transform: translateX(6px);
    border-left:6px solid #fff;
}

.sidebar a:hover{
    background: rgba(255,255,255,0.2);
    transform: translateX(5px);
}

/* MAIN */
.main{
    margin-left:230px;
    padding:20px;
    width:calc(100% - 230px);
}

/* HEADER */
.header{
    background: linear-gradient(135deg, #667eea, #764ba2);
    padding:15px 20px;
    border-radius:12px;
    margin-bottom:20px;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:space-between;
    box-shadow:0 6px 18px rgba(0,0,0,0.15);
}

/* TABLE */
.table-box{
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

/* ICONS */
.icon-btn{
    border:none;
    background:none;
    cursor:pointer;
    font-size:16px;
}

.edit-icon{color:#25a2ff;}
.delete-icon{color:#ff4d4d;}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    top:0;left:0;
    width:100%;height:100%;
    background:rgba(0,0,0,0.5);
    justify-content:center;
    align-items:center;
}

.modal-content{
    background:#fff;
    padding:25px;
    border-radius:12px;
    width:340px;
}

.modal-header{
    display:flex;
    justify-content:space-between;
    margin-bottom:15px;
}

.form-group{margin-bottom:12px;}

.form-group label{
    font-size:14px;
    font-weight:600;
}

.form-group input,
.form-group select{
    width:100%;
    padding:8px;
    margin-top:5px;
    border:1px solid #ccc;
    border-radius:6px;
}

.modal-actions{
    display:flex;
    gap:10px;
    margin-top:10px;
}

.cancel-btn{
    flex:1;
    background:#eee;
    border:none;
    padding:8px;
    border-radius:6px;
}

.save-btn{
    flex:1;
    background:#667eea;
    color:#fff;
    border:none;
    padding:8px;
    border-radius:6px;
}

/* LOGOUT */
.logout button{
    width:100%;
    padding:10px;
    border:none;
    border-radius:8px;
    background:#fff;
    color:#667eea;
}

</style>

<script>
function openEdit(id,name,email,role){
    document.getElementById("modal").style.display="flex";
    document.getElementById("user_id").value=id;
    document.getElementById("name").value=name;
    document.getElementById("email").value=email;
    document.getElementById("role").value=role;
}

function closeModal(){
    document.getElementById("modal").style.display="none";
}
</script>

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

<div class="header">
    <h2><i class="fas fa-users"></i> Manage Users</h2>
</div>

<div class="table-box">
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Actions</th>
</tr>

<?php while($row=mysqli_fetch_assoc($users)): ?>
<tr>
<td><?php echo $row['user_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['role']; ?></td>

<td>
<?php if($row['user_id'] != $_SESSION['user_id']): ?>

<button class="icon-btn edit-icon"
onclick="openEdit('<?php echo $row['user_id']; ?>','<?php echo $row['name']; ?>','<?php echo $row['email']; ?>','<?php echo $row['role']; ?>')">
<i class="fas fa-edit"></i>
</button>

<a href="?delete=<?php echo $row['user_id']; ?>"
onclick="return confirm('Delete user?')" class="icon-btn delete-icon">
<i class="fas fa-trash"></i>
</a>

<?php else: ?>
Current
<?php endif; ?>
</td>

</tr>
<?php endwhile; ?>
</table>
</div>

</div>
</div>

<!-- MODAL -->
<div class="modal" id="modal">
<div class="modal-content">

<div class="modal-header">
<h3>Edit User</h3>
<span onclick="closeModal()" style="cursor:pointer;">&times;</span>
</div>

<form method="POST">
<input type="hidden" name="user_id" id="user_id">

<div class="form-group">
<label>Name</label>
<input type="text" name="name" id="name">
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email" id="email">
</div>

<div class="form-group">
<label>Role</label>
<select name="role" id="role">
<option value="user">User</option>
<option value="admin">Admin</option>
</select>
</div>

<div class="modal-actions">
<button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
<button type="submit" name="update_user" class="save-btn">Update</button>
</div>

</form>

</div>
</div>

</body>
</html>