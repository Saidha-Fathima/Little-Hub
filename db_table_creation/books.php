<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "lithub_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to create the books table
$sql = "CREATE TABLE books (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    file_path VARCHAR(255),
    cover_image VARCHAR(255),
    price DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo 'Books table created successfully';
} else {
    echo 'Error creating table: ' . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>