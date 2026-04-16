<?php
session_start();
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM books ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Books</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<meta charset="UTF-8">
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
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    transition:0.3s;
    text-align:left;
}

.card:hover {
    transform:translateY(-6px);
}

/* IMAGE */
.card img {
    width:100%;
    height:160px;
    object-fit:cover;
    border-radius:8px;
    margin-bottom:10px;
}

/* TEXT */
.card h3 {
    margin:5px 0;
    font-size:18px;
    color:#333;
}

.info {
    font-size:14px;
    color:#555;
    margin:4px 0;
}

.price {
    font-size:15px;
    font-weight:bold;
    color:#2e7d32;
    margin:6px 0;
}

/* VIEW BUTTON */
.btn {
    display:inline-block;
    margin-top:10px;
    padding:8px 12px;
    background:#667eea;
    color:#fff;
    border-radius:6px;
    text-decoration:none;
    text-align:center;
    transition:0.3s;
}

.btn:hover {
    background:#5a67d8;
}

.view-icon {
    margin-right:6px;
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
            <a href="books.php" class="nav-link active">Books</a>
            <a href="notes.php" class="nav-link">Notes</a>
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

<h2 style="text-align:center; margin-top:30px;">Books</h2>

<!-- GRID -->
<div class="grid">

<?php while($row = mysqli_fetch_assoc($result)): ?>
<div class="card">

    <img src="<?php echo $row['cover_image']; ?>">

    <h3><?php echo $row['title']; ?></h3>

    <p class="info"><strong>Author:</strong> <?php echo $row['author']; ?></p>

    <p class="info"><strong>Category:</strong> <?php echo $row['category']; ?></p>

    <p class="price"> ₹ <?php echo $row['price']; ?></p>

    <a href="<?php echo $row['file_path']; ?>" class="btn" target="_blank">
        <i class="fas fa-eye view-icon"></i> View
    </a>

</div>
<?php endwhile; ?>

</div>

</body>
</html>