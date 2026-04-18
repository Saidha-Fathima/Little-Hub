<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

include '../db.php';

/* ========= ADD BOOK ========= */
if(isset($_POST['add_book'])){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $pdf = $_FILES['pdf']['name'];
    $cover = $_FILES['cover']['name'];

    move_uploaded_file($_FILES['pdf']['tmp_name'], "../uploads/books/".$pdf);
    move_uploaded_file($_FILES['cover']['tmp_name'], "../uploads/covers/".$cover);

    mysqli_query($conn,"INSERT INTO books(title,author,category,file_path,cover_image,price)
    VALUES('$title','$author','$category','uploads/books/$pdf','uploads/covers/$cover','$price')");
}

/* ========= DELETE ========= */
if(isset($_GET['delete'])){
    mysqli_query($conn,"DELETE FROM books WHERE book_id=".$_GET['delete']);
}

/* ========= FETCH ========= */
$books = mysqli_query($conn,"SELECT * FROM books ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>LittleHUB - Manage Books</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<meta charset="UTF-8">
<style>

/* RESET */
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:Segoe UI, sans-serif;
    background:#f4f6fb;
}

/* WRAPPER */
.wrapper{display:flex;}

/* SIDEBAR (UNCHANGED) */
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
    transform:translateX(6px);
    border-left:6px solid #fff;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.2);
    transform:translateX(5px);
}

/* MAIN */
.main{
    margin-left:230px;
    padding:20px;
    width:calc(100% - 230px);
}

/* HEADER (UNCHANGED) */
.header{
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

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}

.form-card input{
    padding:10px;
    border:1px solid #ccc;
    border-radius:6px;
    width:100%;
}

.add-btn{
    grid-column:span 2;
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

input[type="file"]{
    width:100%;
    padding:8px;
    border:1px solid #ccc;
    border-radius:6px;
    background:#f9f9f9;
    cursor:pointer;
}

/* style file selector button */
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

/* TABLE */
.table-card{
    background:#fff;
    border-radius:12px;
    padding:15px;
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

.delete-icon{color:#ff4d4d;}

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

<!-- SIDEBAR -->
<div class="sidebar">
    <div>
        <h2><i class="fas fa-user-shield"></i> LittleHUB Admin</h2>

        <a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
        <a href="manage_books.php" class="active"><i class="fas fa-book"></i> Manage Books</a>
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
    <h2><i class="fas fa-book"></i> Manage Books</h2>
</div>

<!-- ADD BOOK -->
<div class="form-card">
<h3>Add New Book</h3>

<form method="POST" enctype="multipart/form-data" class="form-grid">

<input type="text" name="title" placeholder="Title" required>
<input type="text" name="author" placeholder="Author" required>

<input type="text" name="category" placeholder="Category" required>
<input type="number" name="price" placeholder="Price" required>

<input type="file" name="pdf" required>
<input type="file" name="cover" required>

<button name="add_book" class="add-btn">Add Book</button>

</form>
</div>

<!-- TABLE -->
<div class="table-card">

<table>
<tr>
<th>ID</th>
<th>Title</th>
<th>Author</th>
<th>Category</th>
<th>Price</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($books)): ?>
<tr>
<td><?= $row['book_id'] ?></td>
<td><?= $row['title'] ?></td>
<td><?= $row['author'] ?></td>
<td><?= $row['category'] ?></td>
<td>₹<?= $row['price'] ?></td>

<td>
<a href="?delete=<?= $row['book_id'] ?>"
onclick="return confirm('Delete book?')"
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