<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact - LittleHUB</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>

/* BODY */
body {
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
}

/* HERO */
.hero {
    text-align:center;
    color:#fff;
    padding:70px 15px 20px; /* reduced gap */
    animation: fadeIn 1s ease-in-out;
}

.hero h1 {
    margin:0;
    font-size:32px;
}

/* CONTAINER */
.container {
    max-width:800px;
    margin:20px auto; /* reduced gap */
    padding:10px;
}

/* CARD */
.card {
    background:#fff;
    border-radius:10px;
    padding:20px;
    margin-bottom:15px; /* reduced gap */
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    animation: slideUp 0.6s ease;
}

/* CONTACT ITEMS */
.contact-item {
    margin:10px 0;
    font-size:15px;
}

.contact-item i {
    color:#667eea;
    margin-right:8px;
}

/* FORM */
.form-group {
    margin-bottom:10px;
}

input, textarea {
    width:100%;
    padding:10px;
    border-radius:6px;
    border:1px solid #ddd;
    outline:none;
    font-size:14px;
}

textarea {
    resize:none;
}

/* BUTTON */
.btn-send {
    background:#667eea;
    color:#fff;
    padding:10px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    width:100%;
    transition:0.3s;
}

.btn-send:hover {
    background:#5a67d8;
}

/* ANIMATIONS */
@keyframes fadeIn {
    from {opacity:0;}
    to {opacity:1;}
}

@keyframes slideUp {
    from {
        transform:translateY(20px);
        opacity:0;
    }
    to {
        transform:translateY(0);
        opacity:1;
    }
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
            <a href="notes.php" class="nav-link">Notes</a>
            <a href="store.php" class="nav-link">Store</a>
            <a href="aboutus.php" class="nav-link active">About us</a>
        </div>

        <div class="nav-actions">
            <button class="btn btn-primary" onclick="location.href='logout.php'">Logout</button>
        </div>
    </div>
</nav>

<!-- HERO -->
<div class="hero">
    <h1>Welcome to LittleHUB</h1>
</div>

<!-- CONTENT -->
<div class="container">

    <!-- CONTACT INFO -->
    <div class="card">
        <h3>Get in Touch</h3>

        <div class="contact-item">
            <i class="fas fa-user"></i> Saidha Fathima
        </div>

        <div class="contact-item">
            <i class="fas fa-envelope"></i> your-email@example.com
        </div>

        <div class="contact-item">
            <i class="fas fa-phone"></i> +91 98765 43210
        </div>
    </div>

    <!-- CONTACT FORM -->
    <div class="card">
        <h3>Send Message</h3>

        <form>
            <div class="form-group">
                <input type="text" placeholder="Your Name" required>
            </div>

            <div class="form-group">
                <input type="email" placeholder="Your Email" required>
            </div>

            <div class="form-group">
                <textarea rows="4" placeholder="Your Message" required></textarea>
            </div>

            <button type="submit" class="btn-send">Send Message</button>
        </form>
    </div>

</div>

</body>
</html>