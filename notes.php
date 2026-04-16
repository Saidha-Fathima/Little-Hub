<?php
session_start();
include 'db.php';

/* QUERY */
$query = "SELECT * FROM notes ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

/* FALLBACK */
if (!$result) {
    $query = "SELECT * FROM notes";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("SQL Error: " . mysqli_error($conn));
    }
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
    margin-top:40px;
}

/* CARD */
.card {
    background:#fff;
    border-radius:12px;
    padding:15px;
    text-align:left;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover {
    transform:translateY(-6px);
}

/* TITLE */
.card h3 {
    margin:8px 0;
    font-size:18px;
    color:#333;
}

/* SUBJECT (CATEGORY STYLE) */
.subject {
    display:inline-block;
    background:#eef2ff;
    color:#4f46e5;
    padding:4px 8px;
    border-radius:6px;
    font-size:12px;
    margin-bottom:8px;
}

/* BUTTONS */
.btn {
    display:inline-block;
    padding:8px 10px;
    border-radius:6px;
    text-decoration:none;
    font-size:13px;
    margin-right:5px;
    transition:0.3s;
}

/* VIEW BUTTON */
.btn-view {
    background:#667eea;
    color:#fff;
}

.btn-view:hover {
    background:#5a67d8;
}

/* DOWNLOAD BUTTON */
.btn-download {
    background:#22c55e;
    color:#fff;
}

.btn-download:hover {
    background:#16a34a;
}

/* ICON */
.icon {
    margin-right:5px;
    color:#667eea;
}

</style>
</head>

<body>

<!-- NAVBAR -->
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

<h2 style="text-align:center; margin-top:30px;">
    <i class="fas fa-sticky-note icon"></i> Notes
</h2>

<!-- GRID -->
<div class="grid">

<?php while($row = mysqli_fetch_assoc($result)): ?>
<div class="card">

    <h3>
        <i class="fas fa-file-alt icon"></i>
        <?php echo $row['title']; ?>
    </h3>

    <span class="subject">
        <?php echo $row['subject']; ?>
    </span>

    <div style="margin-top:10px;">
        <!-- VIEW BUTTON -->
        <a href="<?php echo $row['file_path']; ?>" target="_blank" class="btn btn-view">
            <i class="fas fa-eye"></i> View
        </a>

        <!-- DOWNLOAD BUTTON -->
        <a href="<?php echo $row['file_path']; ?>" download class="btn btn-download">
            <i class="fas fa-download"></i> Download
        </a>
    </div>

</div>
<?php endwhile; ?>

</div>

</body>
</html>