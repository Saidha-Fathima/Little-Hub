<?php
$conn = mysqli_connect("localhost", "root", "", "lithub_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "<h2>Seeding Sample Data...</h2>";

/* ================= USERS ================= */
$password = md5("123456");

$users = array(
    array("Admin User", "admin@lithub.com", $password, "admin"),
    array("Saidha Fathima", "saidha@gmail.com", $password, "user"),
    array("Prithi", "prithi@gmail.com", $password, "user")
);

foreach ($users as $user) {
    $name = $user[0];
    $email = $user[1];
    $pass = $user[2];
    $role = $user[3];

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO users (name,email,password,role)
        VALUES ('$name','$email','$pass','$role')");
    }
}
echo "Users inserted<br>";

/* ================= BOOKS ================= */
$books = array(
    array("Java Programming", "James Gosling", "Programming", "Learn Java basics", "uploads/books/java.pdf", "uploads/covers/java.jpg", 199.00),
    array("Web Development", "MDN", "Web", "HTML CSS JS Guide", "uploads/books/web.pdf", "uploads/covers/web.jpg", 149.00),
    array("Data Structures", "Mark Allen", "CS", "DSA concepts", "uploads/books/dsa.pdf", "uploads/covers/dsa.jpg", 249.00)
);

foreach ($books as $b) {
    $title = $b[0];
    $author = $b[1];
    $category = $b[2];
    $desc = $b[3];
    $file = $b[4];
    $cover = $b[5];
    $price = $b[6];

    mysqli_query($conn, "INSERT INTO books (title,author,category,description,file_path,cover_image,price)
    VALUES ('$title','$author','$category','$desc','$file','$cover','$price')");
}
echo "Books inserted<br>";

/* ================= NOTES ================= */

// get a user_id for foreign key
$userRes = mysqli_query($conn, "SELECT user_id FROM users LIMIT 1");
$userRow = mysqli_fetch_assoc($userRes);
$user_id = $userRow['user_id'];

$notes = array(
    array("DBMS", "Normalization Notes", "DBMS notes PDF", "uploads/notes/dbms.pdf"),
    array("Java", "OOP Concepts", "Java OOP notes", "uploads/notes/java.pdf"),
    array("Web", "HTML Basics", "HTML beginner notes", "uploads/notes/web.pdf")
);

foreach ($notes as $n) {
    $subject = $n[0];
    $title = $n[1];
    $desc = $n[2];
    $file = $n[3];

    mysqli_query($conn, "INSERT INTO notes (subject,title,description,file_path,uploaded_by)
    VALUES ('$subject','$title','$desc','$file','$user_id')");
}
echo "Notes inserted<br>";

/* ================= ONLINE BOOKS ================= */
$onlineBooks = array(
    array("C Programming", "Dennis Ritchie", "Programming", "C language guide", "uploads/covers/c.jpg", "uploads/books/c_online.pdf"),
    array("Python Basics", "Guido van Rossum", "Programming", "Python intro", "uploads/covers/python.jpg", "uploads/books/python_online.pdf"),
    array("Java Fundamentals", "James Gosling", "Programming", "Core Java concepts", "uploads/covers/java.jpg", "uploads/books/java_online.pdf"),
    array("Web Development", "Tim Berners-Lee", "Web", "HTML, CSS, JS basics", "uploads/covers/web.jpg", "uploads/books/web_online.pdf"),
    array("Data Structures & Algorithms", "Robert Lafore", "DSA", "DSA concepts and problems", "uploads/covers/dsa.jpg", "uploads/books/dsa_online.pdf")
);

foreach ($onlineBooks as $ob) {
    mysqli_query($conn, "INSERT INTO online_books (title,author,category,description,cover_image,content_path)
    VALUES ('$ob[0]','$ob[1]','$ob[2]','$ob[3]','$ob[4]','$ob[5]')");
}
echo "Online books inserted<br>";

/* ================= ACTIVITY LOG ================= */
$activities = array(
    array($user_id, "Logged in"),
    array($user_id, "Viewed a book"),
    array($user_id, "Downloaded notes")
);

foreach ($activities as $a) {
    mysqli_query($conn, "INSERT INTO activity_log (user_id, action)
    VALUES ('$a[0]', '$a[1]')");
}
echo "Activity logs inserted<br>";

echo "<h3>Sample Data Inserted Successfully!</h3>";

mysqli_close($conn);
?>