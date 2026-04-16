<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LittleHUB - Your Digital Learning Hub</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
   <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <i class="fas fa-book-open"></i>
                <span>LittleHUB</span>
            </div>
            
            <div class="nav-menu" id="navMenu">
                <a href="dashboard.php" class="nav-link" data-section="dashboard">dashboard</a>
                <a href="books.php" class="nav-link" data-section="books">Books</a>
                <a href="notes.php" class="nav-link active" data-section="notes">Notes</a>
                <a href="store.php" class="nav-link" data-section="store">Store</a>
                <a href="aboutus.php" class="nav-link" data-section="aboutus">About Us</a>
            </div>
            
            <div class="nav-actions">
                <button class="btn btn-primary" onclick="window.location.href='index.html'">Logout</button>
            </div>
        </div>
    </nav>

    <main id="mainContent">
    
            <h1 class="hero-title">Welcome to LittleHUB <u>notes</u></h1>

    </main>

</body>
</html>