<?php
session_start();
include 'db.php';

/* FILTER */
$subject = isset($_GET['subject']) ? trim($_GET['subject']) : '';

$sql = "SELECT * FROM notes WHERE 1=1";

if($subject != ''){
    $subject_safe = mysqli_real_escape_string($conn, $subject);
    $sql .= " AND subject='".$subject_safe."'";
}

/* FIX: no created_at column */
$sql .= " ORDER BY note_id DESC";

$result = mysqli_query($conn, $sql);

if(!$result){
    die("Notes Query Error: " . mysqli_error($conn));
}

/* SUBJECT LIST */
$subResult = mysqli_query($conn, "SELECT DISTINCT subject FROM notes");

if(!$subResult){
    die("Subject Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Notes</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>

/* GRID */
.grid {
    max-width:1000px;
    margin:auto;
    display:grid;
    grid-template-columns: repeat(auto-fill,minmax(240px,1fr));
    gap:20px;
    margin-top:20px;
}

/* CARD */
.card {
    background:#fff;
    border-radius:12px;
    padding:15px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover {
    transform:translateY(-6px);
}

.card h3 {
    margin:8px 0;
    font-size:18px;
}

.subject {
    display:inline-block;
    background:#eef2ff;
    color:#4f46e5;
    padding:4px 8px;
    border-radius:6px;
    font-size:12px;
}

.btn {
    display:inline-block;
    padding:8px 10px;
    border-radius:6px;
    text-decoration:none;
    font-size:13px;
    margin-right:5px;
}

.btn-view {
    background:#667eea;
    color:#fff;
}

.btn-download {
    background:#22c55e;
    color:#fff;
}

.icon {
    margin-right:5px;
    color:#667eea;
}

/* FILTER */
.filter-box{
    max-width:1000px;
    margin:20px auto;
    display:flex;
    justify-content:center;
}

.filter-form{
    background:#fff;
    padding:12px 15px;
    border-radius:12px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);

    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

.filter-form select{
    padding:10px 12px;
    border:1px solid #ddd;
    border-radius:8px;
    background:#f9f9f9;
    font-size:14px;

    min-width:320px;
    max-width:450px;
}

.icon-btn{
    width:42px;
    height:42px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:15px;
}

.search-btn{
    background:#667eea;
    color:#fff;
}

.clear-btn{
    background:#e74c3c;
    color:#fff;
    text-decoration:none;
}

@media(max-width:768px){

    .filter-form{
        width:100%;
        justify-content:center;
    }

    .filter-form select{
        width:100%;
        min-width:100%;
    }

    .icon-btn{
        width:100%;
    }
}

</style>
</head>

<body>

<!-- ✅ NAVBAR (UNCHANGED — EXACT SAME AS YOUR ORIGINAL) -->
<nav class="navbar">
    <div class="nav-container">
        <div class="nav-brand">
            <i class="fas fa-book-open"></i> LittleHUB
        </div>

        <div class="nav-menu">
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="books.php" class="nav-link">Books</a>
            <a href="notes.php" class="nav-link active">Notes</a>
            <a href="store.php" class="nav-link">Store</a>
            <a href="aboutus.php" class="nav-link">About Us</a>
        </div>

        <div class="nav-actions">
            <button class="btn btn-primary" onclick="location.href='logout.php'">
                Logout
            </button>
        </div>
    </div>
</nav>

<h2 style="text-align:center; margin-top:25px;">
    <i class="fas fa-sticky-note icon"></i> Notes
</h2>

<!-- FILTER -->
<div class="filter-box">

<form method="GET" class="filter-form">

    <select name="subject">
        <option value="">All Subjects</option>

        <?php while($s = mysqli_fetch_assoc($subResult)){ ?>
        <option value="<?php echo $s['subject']; ?>"
        <?php if($subject == $s['subject']) echo "selected"; ?>>
            <?php echo $s['subject']; ?>
        </option>
        <?php } ?>

    </select>

    <button type="submit" class="icon-btn search-btn">
        <i class="fas fa-search"></i>
    </button>

    <?php if($subject != ''){ ?>
    <a href="notes.php" class="icon-btn clear-btn">
        <i class="fas fa-times"></i>
    </a>
    <?php } ?>

</form>

</div>

<!-- GRID -->
<div class="grid">

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<div class="card">

    <h3>
        <i class="fas fa-file-alt icon"></i>
        <?php echo $row['title']; ?>
    </h3>

    <span class="subject">
        <?php echo $row['subject']; ?>
    </span>

    <div style="margin-top:10px;">
        <a href="<?php echo $row['file_path']; ?>" target="_blank" class="btn btn-view">
            <i class="fas fa-eye"></i> View
        </a>

        <a href="<?php echo $row['file_path']; ?>" download class="btn btn-download">
            <i class="fas fa-download"></i> Download
        </a>
    </div>

</div>
<?php } ?>

</div>

</body>
</html>