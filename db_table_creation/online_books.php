<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "lithub_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to create the online_books table
$sql = "CREATE TABLE online_books (
    online_book_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(150) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    cover_image VARCHAR(255) NOT NULL,
    content_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo "Online Books table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>