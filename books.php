<?php
session_start();
include 'db.php';

/* FILTER */
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

$sql = "SELECT * FROM books WHERE 1=1";

if($category != ''){
    $sql .= " AND category='".mysqli_real_escape_string($conn,$category)."'";
}

$sql .= " ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);

$catResult = mysqli_query($conn,"SELECT DISTINCT category FROM books");
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

.card img {
    width:100%;
    height:160px;
    object-fit:cover;
    border-radius:8px;
}

.card h3 {
    margin:8px 0;
    font-size:18px;
}

.info {
    font-size:14px;
    color:#555;
}

.price {
    font-weight:bold;
    color:#2e7d32;
}

.btn {
    display:inline-block;
    margin-top:10px;
    padding:8px 12px;
    background:#667eea;
    color:#fff;
    border-radius:6px;
    text-decoration:none;
}

/* ================= FILTER CENTER ================= */

.filter-box{
    max-width:1000px;
    margin:25px auto;
    display:flex;
    justify-content:center;   /* ✅ CENTER ALIGN */
}

/* FILTER CARD */
.filter-form{
    background:#fff;
    padding:12px 16px;
    border-radius:12px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);

    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
    justify-content:center; /* ensures inner centering */
}

/* SELECT */
.filter-form select{
    padding:10px 12px;
    border:1px solid #ddd;
    border-radius:8px;
    background:#f9f9f9;
    font-size:14px;

    min-width:320px;
    max-width:450px;
}

/* ICON BUTTONS */
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
    transition:0.3s;
}

/* SEARCH */
.search-btn{
    background:#667eea;
    color:#fff;
}

.search-btn:hover{
    background:#5a67d8;
}

/* CLEAR */
.clear-btn{
    background:#e74c3c;
    color:#fff;
    text-decoration:none;
}

.clear-btn:hover{
    background:#d6453a;
}

/* RESPONSIVE */
@media(max-width:768px){

    .filter-form{
        width:100%;
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

<!-- NAVBAR (UNCHANGED EXACTLY AS YOU HAVE) -->
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

<h2 style="text-align:center;margin-top:20px;">Books</h2>

<!-- FILTER (CENTERED) -->
<div class="filter-box">

<form method="GET" class="filter-form">

    <select name="category">
        <option value="">All Categories</option>

        <?php while($c = mysqli_fetch_assoc($catResult)){ ?>
        <option value="<?php echo $c['category']; ?>"
        <?php if($category == $c['category']) echo "selected"; ?>>
            <?php echo $c['category']; ?>
        </option>
        <?php } ?>

    </select>

    <!-- SEARCH -->
    <button type="submit" class="icon-btn search-btn">
        <i class="fas fa-search"></i>
    </button>

    <!-- CLEAR -->
    <?php if($category != ''){ ?>
    <a href="books.php" class="icon-btn clear-btn">
        <i class="fas fa-times"></i>
    </a>
    <?php } ?>

</form>

</div>

<!-- GRID -->
<div class="grid">

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<div class="card">

    <img src="<?php echo $row['cover_image']; ?>">

    <h3><?php echo $row['title']; ?></h3>

    <p class="info"><strong>Author:</strong> <?php echo $row['author']; ?></p>

    <p class="info"><strong>Category:</strong> <?php echo $row['category']; ?></p>

    <p class="price">₹ <?php echo $row['price']; ?></p>

    <a href="<?php echo $row['file_path']; ?>" class="btn" target="_blank">
        <i class="fas fa-eye"></i> View
    </a>

</div>
<?php } ?>

</div>

</body>
</html>