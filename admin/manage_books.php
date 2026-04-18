<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

include '../db.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/* ========= ADD BOOK ========= */
if(isset($_POST['add_book'])){

    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);

    $pdfName = time() . "_" . basename($_FILES['pdf']['name']);
    $coverName = time() . "_" . basename($_FILES['cover']['name']);

    $pdfPath = "uploads/books/".$pdfName;
    $coverPath = "uploads/covers/".$coverName;

    if(!file_exists("../uploads/books")) mkdir("../uploads/books", 0755, true);
    if(!file_exists("../uploads/covers")) mkdir("../uploads/covers", 0755, true);

    move_uploaded_file($_FILES['pdf']['tmp_name'], "../".$pdfPath);
    move_uploaded_file($_FILES['cover']['tmp_name'], "../".$coverPath);

    $stmt = $conn->prepare("INSERT INTO books(title,author,category,description,file_path,cover_image,price)
                            VALUES(?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssd",$title,$author,$category,$description,$pdfPath,$coverPath,$price);
    $stmt->execute();

    header("Location: manage_books.php");
    exit();
}

/* ========= FETCH EDIT DATA ========= */
$editData = array();

if(isset($_GET['edit'])){
    $id = intval($_GET['edit']);
    $res = mysqli_query($conn,"SELECT * FROM books WHERE book_id=$id");
    if($res){
        $editData = mysqli_fetch_assoc($res);
    }
}

/* ========= UPDATE ========= */
if(isset($_POST['update_book'])){

    $id = intval($_POST['book_id']);
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);

    $stmt = $conn->prepare("UPDATE books SET title=?,author=?,category=?,description=?,price=? WHERE book_id=?");
    $stmt->bind_param("ssssdi",$title,$author,$category,$description,$price,$id);
    $stmt->execute();

    header("Location: manage_books.php");
    exit();
}

/* ========= DELETE ========= */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("DELETE FROM books WHERE book_id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();

    header("Location: manage_books.php");
    exit();
}

/* ========= FETCH ALL ========= */
$books = mysqli_query($conn,"SELECT * FROM books ORDER BY book_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>LittleHUB - Manage Books</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<meta charset="UTF-8">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:Segoe UI;background:#f4f6fb;}
.wrapper{display:flex;}

/* SIDEBAR */
.sidebar{
    width:230px;height:100vh;
    background:linear-gradient(180deg,#667eea,#764ba2);
    color:#fff;position:fixed;
    display:flex;flex-direction:column;
    justify-content:space-between;padding:15px;
}

.sidebar h2{font-size:16px;margin-bottom:15px;}

.sidebar a{
    display:block;color:#fff;text-decoration:none;
    padding:10px;border-radius:8px;margin-bottom:6px;
}

.sidebar a.active{
    background:#fff;color:#667eea;font-weight:bold;
}

.logout button{
    width:100%;padding:10px;border:none;
    border-radius:8px;background:#fff;
    color:#667eea;cursor:pointer;
}

/* MAIN */
.main{
    margin-left:230px;padding:20px;width:calc(100% - 230px);
}

/* HEADER */
.header{
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:#fff;padding:15px;border-radius:12px;
    margin-bottom:20px;
}

/* FORM */
.form-card{
    background:#fff;padding:20px;
    border-radius:12px;margin-bottom:20px;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
}

input,textarea{
    padding:10px;border:1px solid #ccc;border-radius:6px;
}

textarea{grid-column:span 2;}

button{
    grid-column:span 2;
    padding:10px;background:#667eea;
    color:#fff;border:none;border-radius:6px;
    cursor:pointer;
}

/* TABLE */
table{
    width:100%;
    background:#fff;
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

.edit-icon{color:green;margin-right:10px;}
.delete-icon{color:red;}
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
        <a href="manage_books.php" class="active"><i class="fas fa-book"></i> Books</a>
        <a href="manage_notes.php"><i class="fas fa-sticky-note"></i> Notes</a>
        <a href="activity_logs.php"><i class="fas fa-chart-line"></i> Logs</a>
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
<h2><i class="fas fa-book"></i> 
<?php echo isset($editData['book_id']) ? "Edit Book" : "Add Book"; ?>
</h2>
</div>

<!-- FORM -->
<div class="form-card">
<form method="POST" enctype="multipart/form-data" class="form-grid">

<input type="hidden" name="book_id"
value="<?php echo isset($editData['book_id']) ? $editData['book_id'] : ''; ?>">

<input type="text" name="title" required placeholder="Title"
value="<?php echo isset($editData['title']) ? $editData['title'] : ''; ?>">

<input type="text" name="author" required placeholder="Author"
value="<?php echo isset($editData['author']) ? $editData['author'] : ''; ?>">

<input type="text" name="category" required placeholder="Category"
value="<?php echo isset($editData['category']) ? $editData['category'] : ''; ?>">

<input type="number" name="price" required placeholder="Price"
value="<?php echo isset($editData['price']) ? $editData['price'] : ''; ?>">

<textarea name="description" placeholder="Description"><?php 
echo isset($editData['description']) ? $editData['description'] : ''; 
?></textarea>

<?php if(!isset($editData['book_id'])){ ?>
<input type="file" name="pdf" required>
<input type="file" name="cover" required>
<?php } ?>

<button name="<?php echo isset($editData['book_id']) ? 'update_book' : 'add_book'; ?>">
<?php echo isset($editData['book_id']) ? 'Update Book' : 'Add Book'; ?>
</button>

</form>
</div>

<!-- TABLE -->
<table>
<tr>
<th>ID</th>
<th>Title</th>
<th>Author</th>
<th>Category</th>
<th>Price</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($books)){ ?>
<tr>
<td><?php echo $row['book_id']; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['author']; ?></td>
<td><?php echo $row['category']; ?></td>
<td>₹<?php echo $row['price']; ?></td>

<td>
<a href="?edit=<?php echo $row['book_id']; ?>" class="edit-icon">
<i class="fas fa-edit"></i>
</a>

<a href="?delete=<?php echo $row['book_id']; ?>" 
onclick="return confirm('Delete this book?')" 
class="delete-icon">
<i class="fas fa-trash"></i>
</a>
</td>

</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>