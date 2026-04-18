<?php
session_start();
include 'db.php';

/* FILTER VALUES */
$title = isset($_GET['title']) ? trim($_GET['title']) : '';
$author = isset($_GET['author']) ? trim($_GET['author']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$min_price = isset($_GET['min_price']) ? trim($_GET['min_price']) : '';
$max_price = isset($_GET['max_price']) ? trim($_GET['max_price']) : '';

$sql = "SELECT * FROM books WHERE 1=1";

if($title != ''){
    $sql .= " AND title LIKE '%".mysqli_real_escape_string($conn,$title)."%'";
}

if($author != ''){
    $sql .= " AND author LIKE '%".mysqli_real_escape_string($conn,$author)."%'";
}

if($category != ''){
    $sql .= " AND category='".mysqli_real_escape_string($conn,$category)."'";
}

if($min_price != ''){
    $sql .= " AND price >= ".floatval($min_price);
}

if($max_price != ''){
    $sql .= " AND price <= ".floatval($max_price);
}

$sql .= " ORDER BY book_id DESC";

$result = mysqli_query($conn, $sql);

if(!$result){
    die("Store Query Error: " . mysqli_error($conn));
}

$catResult = mysqli_query($conn,"SELECT DISTINCT category FROM books");
?>

<!DOCTYPE html>
<html>
<head>
<title>Store</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<meta charset="UTF-8">

<style>

/* ONLY SAFE GLOBAL SPACING (NO MAX-WIDTH USED) */
body{
    margin:0;
    padding:0;
    font-family:Segoe UI;
    background:#f4f6fb;
}

/* gives breathing space without touching navbar */
.page-container{
    padding:0 35px;
}

/* FILTER */
.filter-box{
    width:100%;
    margin-top:20px;
    background:#fff;
    padding:15px;
    border-radius:12px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
}

.filter-form{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    align-items:center;
    justify-content:center;
}

.filter-form input,
.filter-form select{
    padding:10px;
    border:1px solid #ddd;
    border-radius:8px;
    font-size:14px;
    min-width:180px;
}

.price-input{
    width:140px;
}

.search-btn{
    padding:10px 14px;
    border:none;
    background:#667eea;
    color:#fff;
    border-radius:8px;
    cursor:pointer;
}

.search-btn:hover{
    background:#5a67d8;
}

.clear-btn{
    padding:10px 14px;
    background:#e74c3c;
    color:#fff;
    border-radius:8px;
    text-decoration:none;
}

/* GRID */
.grid{
    width:100%;
    display:grid;
    grid-template-columns: repeat(auto-fill,minmax(230px,1fr));
    gap:20px;
    margin-top:25px;
}

/* CARD */
.card{
    background:#fff;
    border-radius:12px;
    padding:15px;
    text-align:center;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-6px);
}

.card img{
    width:100%;
    height:150px;
    object-fit:cover;
    border-radius:8px;
}

.card h3{
    margin:8px 0 5px;
}

.info{
    font-size:14px;
    color:#555;
}

.price{
    font-weight:bold;
    color:#2e7d32;
}

.btn-buy{
    display:inline-block;
    margin-top:10px;
    padding:8px 12px;
    background:#667eea;
    color:#fff;
    border-radius:6px;
    border:none;
    cursor:pointer;
}

.btn-buy:hover{
    background:#5a67d8;
}

/* RESPONSIVE */
@media(max-width:768px){
    .page-container{
        padding:0 15px;
    }

    .filter-form{
        flex-direction:column;
    }

    .filter-form input,
    .filter-form select{
        width:100%;
    }
}

</style>
</head>

<body>

<!-- NAVBAR (UNCHANGED — EXACT ORIGINAL KEPT) -->
<nav class="navbar">
    <div class="nav-container">
        <div class="nav-brand">
            <i class="fas fa-book-open"></i> LittleHUB
        </div>

        <div class="nav-menu">
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="books.php" class="nav-link">Books</a>
            <a href="notes.php" class="nav-link">Notes</a>
            <a href="store.php" class="nav-link active">Store</a>
            <a href="aboutus.php" class="nav-link">About Us</a>
        </div>

        <div class="nav-actions">
            <button class="btn btn-primary" onclick="location.href='logout.php'">
                Logout
            </button>
        </div>
    </div>
</nav>

<!-- CONTENT WRAPPER (ONLY FOR SPACING) -->
<div class="page-container">

<h2 style="text-align:center;margin-top:25px;">Book Store</h2>

<!-- FILTER -->
<div class="filter-box">

<form method="GET" class="filter-form">

    <input type="text" name="title" placeholder="Title" value="<?php echo $title; ?>">

    <input type="text" name="author" placeholder="Author" value="<?php echo $author; ?>">

    <select name="category">
        <option value="">All Categories</option>
        <?php while($c = mysqli_fetch_assoc($catResult)){ ?>
        <option value="<?php echo $c['category']; ?>"
        <?php if($category == $c['category']) echo "selected"; ?>>
            <?php echo $c['category']; ?>
        </option>
        <?php } ?>
    </select>

    <input type="number" class="price-input" name="min_price" placeholder="Min ₹" value="<?php echo $min_price; ?>">

    <input type="number" class="price-input" name="max_price" placeholder="Max ₹" value="<?php echo $max_price; ?>">

    <button type="submit" class="search-btn">
        <i class="fas fa-search"></i>
    </button>

    <a href="store.php" class="clear-btn">
        <i class="fas fa-times"></i>
    </a>

</form>

</div>

<!-- GRID -->
<div class="grid">

<?php while($row = mysqli_fetch_assoc($result)): ?>
<div class="card">

    <img src="<?php echo $row['cover_image']; ?>">

    <h3><?php echo $row['title']; ?></h3>

    <p class="info"><strong>Author:</strong> <?php echo $row['author']; ?></p>

    <p class="info"><strong>Category:</strong> <?php echo $row['category']; ?></p>

    <p class="price">&#8377; <?php echo $row['price']; ?></p>

    <button class="btn-buy">Buy Now</button>

</div>
<?php endwhile; ?>

</div>

</div>

</body>
</html>